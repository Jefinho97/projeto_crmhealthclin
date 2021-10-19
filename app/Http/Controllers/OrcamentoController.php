<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Orcamento;
use App\Models\Diaria;
use App\Models\Equipe;
use App\Models\Material;
use App\Models\User;


use BaconQrCode\Renderer\Color\Rgb;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use mysqli;
use PhpParser\Node\Stmt\Return_;
use Barryvdh\DomPDF\Facade as PDF;

class OrcamentoController extends Controller
{
    // Paginas Principais

    public function index() {
        
        $user = auth()->user();
        if($user != NULL ) {

        return redirect('/dashboard');

        }

        return view('auth.login');

    }    

    public function dashboard() {

        $user = Auth::user();
        $orcamentos = $user->orcamentos;  
        $quant = count($orcamentos);
        $ordem = null;

        return view('orcamentos.dashboard', ['orcamentos' => $orcamentos, 'quant' => $quant, 'ordem' => $ordem]);
    }

    // Ordenar Dashboard Orçanentos

    public function ordem(Request $request) {
        $orcamentos = Auth::user()->orcamentos;
        $quant = count($orcamentos);

        switch ($request->ordem) {
            case '0':
                $orcamentos = $orcamentos->sortByDesc("data");
                $ordem = 0;
                break;
            case '1':
                $orcamentos = $orcamentos->sortBy("data");
                $ordem = 1;
                break;
            case '2':
                $orcamentos = $orcamentos->sortBy("procedimento");
                $ordem = 2;
                break;
            case '3':
                $orcamentos = $orcamentos->sortByDesc("procedimento");
                $ordem = 3;
                break;
        }
        return view('orcamentos.dashboard', ['orcamentos' => $orcamentos, 'quant' => $quant, 'ordem' => $ordem]);
    }

    // Criar Orçamento

    public function create(){
        $materials = Material::all();
        $diarias = Diaria::all();
        
        return view('orcamentos.create', ['materials' => $materials, 'diarias' => $diarias]);

    }

    
    public function store(Request $request) {
        
        $orcamento = new Orcamento;

        $orcamento->procedimento = $request->procedimento;
        $orcamento->paciente = $request->paciente;
        $orcamento->email_pac = $request->email_pac;
        $orcamento->telefone_1 = $request->telefone_1;
        $orcamento->telefone_2 = $request->telefone_2;
        $orcamento->termos_condicoes = $request->termos_condicoes;
        $orcamento->convenios = $request->convenios;
        $orcamento->condicoes_pag = $request->condicoes_pag;
        $orcamento->data = $request->data;
        $orcamento->tipo = $request->has('tipo');        
        
        $orcamento->user_id = Auth::user()->id;
        $orcamento->save();

        $orcamento = Orcamento::all()->last();
        
        $materials = $request->materials;
        $diarias = $request->diarias;

        $quant = (is_array($materials) ? count($materials) : 0);

        for ($mat=0; $mat < $quant; $mat++) {
            $material = Material::findOrFail($materials[$mat]);
            if (is_null($material) == false){
            $q = $request->quant_mat[$mat];
            $soma_custo = $material->custo * $q;
            $soma_venda = $material->venda * $q;
            switch($material->tipo){
                case "material":
                    $orcamento->venda_material += $soma_venda;
                    $orcamento->custo_material += $soma_custo;
                    break;
                case "medicamento":
                    $orcamento->venda_medicamento += $soma_venda;
                    $orcamento->custo_medicamento += $soma_custo;
                    break;
                case "dieta":
                    $orcamento->venda_dieta += $soma_venda;
                    $orcamento->custo_dieta += $soma_custo;
                    break;
                case "equipamento":
                    $orcamento->venda_equipamento += $soma_venda;
                    $orcamento->custo_equipamento += $soma_custo;
                    break;  
            }
            

            $orcamento->materials()->attach($material->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
            }
        }

        $quant = (is_array($diarias) ? count($diarias) : 0);

        for ($dia=0; $dia < $quant; $dia++) { 
            $diaria = Diaria::findOrFail($diarias[$dia]);
            if (is_null($diaria) == false){
            $orcamento->venda_diaria += $diaria->venda;
            $orcamento->custo_diaria += $diaria->custo;

            $orcamento->diarias()->attach($diaria->id);
            }
        }
        $orcamento->valor_inicial = $orcamento->venda_material + $orcamento->venda_diaria 
        + $orcamento->venda_medicamento + $orcamento->venda_dieta + $orcamento->venda_equipamento;

        $orcamento->update([
            'custo_material' => $orcamento->custo_material, 'venda_material' => $orcamento->venda_material,
            'custo_medicamento' => $orcamento->custo_medicamento, 'venda_medicamento' => $orcamento->venda_medicamento, 
            'custo_dieta' => $orcamento->custo_dieta, 'venda_dieta' => $orcamento->venda_dieta,
            'custo_equipamento' => $orcamento->custo_equipamento, 'venda_equipamento' => $orcamento->venda_equipamento, 
            'custo_diaria' => $orcamento->custo_diaria, 'venda_diaria' => $orcamento->venda_diaria,
            'valor_inicial' => $orcamento->valor_inicial, 'valor_final' => $orcamento->valor_inicial
        ]);

        if($orcamento->tipo == false){
            
            return redirect('/dashboard')->with('msg','Orçamento criado com sucesso!');

        } else { 
            $equipes = Equipe::all();
            return view('orcamentos.create2', ['equipes' => $equipes, 'orcamento' => $orcamento]);
            
        }
    
    }


    public function store2(Request $request){
        $orcamento = Orcamento::findOrFail($request->id);
        
        $equipes = $request->equipes;
        $quant = (is_array($equipes) ? count($equipes) : 0);

        for ($equ=0; $equ < $quant; $equ++) { 
            $equipe = Equipe::findOrFail($equipes[$equ]);
            if (is_null($equipe) == false){
            $q = $request->quant_equ[$equ];
            $soma_custo = $equipe->custo * $q;
            $soma_venda = $equipe->venda * $q;
            $orcamento->custo_equipe += $soma_custo;
            $orcamento->venda_equipe += $soma_venda;

            $orcamento->equipes()->attach($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
            }
        }
        $orcamento->valor_inicial += $orcamento->venda_equipe + $orcamento->preco_medico; 

        $orcamento->update(['medico' => $request->medico, 'preco_medico' => $request->preco_medico, 'venda_equipe' => $orcamento->venda_equipe, 'valor_inicial' => $orcamento->valor_inicial, 'valor_final' => $orcamento->valor_inicial]);

        return redirect('/dashboard')->with('msg','Orçamento criado com sucesso!');
    }

    // Apagar Orçamento

    public function destroy($id) {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->diarias()->detach();
        $orcamento->equipes()->detach();
        $orcamento->materials()->detach();
        $orcamento->delete();

        return redirect('/dashboard')->with('msg', 'Orçamento excluído com sucesso!');
        
    }

    // Editar Orçamento

    public function edit($id) {

        $orcamento = Orcamento::findOrFail($id);
        $materiais = Material::all();
        $diarias = Diaria::all();
        $equipes = Equipe::all();

        return view('orcamentos.edit', ['orcamento' => $orcamento, 'materiais' => $materiais, 'diarias' => $diarias, 
        'equipes' => $equipes]);
    
    }

    public function update(Request $request) {
        $orcamento = Orcamento::findOrFail($request->id);

        $orcamento->diarias()->detach();
        $orcamento->equipes()->detach();
        $orcamento->materials()->detach();

        $materials = $request->materials;
        $diarias = $request->diarias;
        $equipes = $request->equipes;

        $quant = (is_array($materials) ? count($materials) : 0);

        for ($mat=0; $mat < $quant; $mat++) {
            $material = Material::findOrFail($materials[$mat]);
            if(is_null($material) == false){
            $q = $request->quant_mat[$mat];
            $soma_custo = $material->custo * $q;
            $soma_venda = $material->venda * $q;
            $orcamento->total_material += $soma_custo;

            $orcamento->materials()->attach($material->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
            }
        }

        $quant = (is_array($diarias) ? count($diarias) : 0);

        for ($dia=0; $dia < $quant; $dia++) { 
            $diaria = Diaria::findOrFail($diarias[$dia]);
            if(is_null($diaria) == false){
            $orcamento->total_diaria += $diaria->venda;

            $orcamento->diarias()->attach($diaria->id);
            }
        }

        $quant = (is_array($equipes) ? count($equipes) : 0);

        for ($equ=0; $equ < $quant; $equ++) { 
            $equipe = Equipe::findOrFail($equipes[$equ]);
            if(is_null($equipe) == false){
            $q = $request->quant_equ[$equ];
            $soma_custo = $equipe->custo * $q;
            $soma_venda = $equipe->venda * $q;
            $orcamento->total_equipe += $soma_venda;

            $orcamento->equipes()->attach($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
            }
        }

        $orcamento->valor_final = ($orcamento->total_material 
        + $orcamento->total_diaria + $orcamento->total_equipe + $orcamento->preco_medico);

        $orcamento->update([
            'procedimento' => $request->procedimento, 'medico' => $request->medico, 'preco_medico' => $request->preco_medico, 
            'paciente' => $request->paciente, 'email_pac' => $request->email_pac, 'telefone_1' => $request->telefone_1, 
            'telefone_2' => $request->telefone_2, 'data' => $request->data, 'convenios' => $request->convenios,
            'termos_condicoes' => $request->termos_condicoes, 'condicoes_pag' => $request->condicoes_pag, 'valor_final' => $orcamento->valor_final,
        ]);

        return redirect('/dashboard')->with('msg', 'Orçamento editado com sucesso!');

    }

    // Detalhar Orçamento

    public function show($id){
        $orcamento = Orcamento::findOrFail($id);
        $user = auth()->user();

        if($user->id == $orcamento->user_id) {
            $materiais = null;
            $medicamentos = null;
            $dietas = null;
            $equipamentos = null;
            foreach($orcamento->materials as $material){
                switch($material->tipo){
                    case "material":
                        $materiais[] = $material;
                        break;
                    case "medicamento":
                        $medicamentos[] = $material;
                        break;
                    case "dieta":
                        $dietas[] = $material;
                        break;
                    case "equipamento":
                        $equipamentos[] = $material;
                        break;
                }
            }

            return view('orcamentos.show', ['orcamento' => $orcamento, 'materiais' => $materiais, 'dietas' => $dietas, 'medicamentos' => $medicamentos, 'equipamentos' => $equipamentos]);
        } else {
            return redirect('/dashboard');
        }

    }

    public function gerarpdf($id){
        $orcamento = Orcamento::findOrFail($id);
        $pdf = PDF::loadView('orcamentos.pdf', ['orcamento' => $orcamento]);
        return $pdf->setPaper('a4')->stream('pdf.pdf');
    }

    public function up_show(Request $request){
        Orcamento::findOrFail($request->id)->update([ 'desconto' => $request->desconto, 'valor_final' => ($request->valor_inicial - $request->desconto)]);

        return redirect('/orcamentos/' . $request->id)->with('msg', 'Desconto atualizado com sucesso!');
    }

    public function status(Request $request) {
        Orcamento::findOrFail($request->id)->update([ 'status' => $request->status]);
        
        if(is_null($request->ordem)){
            return redirect('/dashboard');  
        } else {
            return redirect('/dashboard/' . $request->ordem);
        }
        
    }

    public function razao_status(Request $request) {

        Orcamento::findOrFail($request->id)->update([ 'razao_status' => $request->razao_status]);

        if(is_null($request->ordem)){
            return redirect('/dashboard');  
        } else {
            return redirect('/dashboard/' . $request->ordem);
        }

    }
}
