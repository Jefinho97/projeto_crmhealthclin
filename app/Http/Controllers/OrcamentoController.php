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

class OrcamentoController extends Controller
{

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
        $ordem = 1;

        return view('orcamentos.dashboard', ['orcamentos' => $orcamentos, 'quant' => $quant, 'ordem' => $ordem]);
    }

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
                $orcamentos = $orcamentos->sortByDesc("procedimento");
                $ordem = 2;
                break;
            case '3':
                $orcamentos = $orcamentos->sortBy("procedimento");
                $ordem = 3;
                break;
        }
        return view('orcamentos.dashboard', ['orcamentos' => $orcamentos, 'quant' => $quant, 'ordem' => $ordem]);
    }

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
        
        $orcamento->user_id = Auth::id();
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
            $orcamento->total_material += $soma_venda;

            $orcamento->materials()->attach($material->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
            }
        }

        $quant = (is_array($diarias) ? count($diarias) : 0);

        for ($dia=0; $dia < $quant; $dia++) { 
            $diaria = Diaria::findOrFail($diarias[$dia]);
            if (is_null($diaria) == false){
            $orcamento->total_diaria += $diaria->venda;

            $orcamento->diarias()->attach($diaria->id);
            }
        }
        $orcamento->valor_inicial = $orcamento->total_material + $orcamento->total_diaria;
        $orcamento->update(['total_material' => $orcamento->total_material, 'total_diaria' => $orcamento->total_diaria, 'total_equipe' => $orcamento->total_equipe, 'valor_inicial' => $orcamento->valor_inicial, 'valor_final' => $orcamento->valor_inicial]);

        if($orcamento->tipo == false){
            
            return redirect('/dashboard')->with('msg','Evento criado com sucesso!');

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
            $orcamento->total_equipe += $soma_venda;

            $orcamento->equipes()->attach($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
            }
        }
        $orcamento->valor_inicial = ($orcamento->total_material 
        + $orcamento->total_diaria + $orcamento->total_equipe + $orcamento->preco_medico); 

        $orcamento->update(['medico' => $request->medico, 'preco_medico' => $request->preco_medico, 'total_equipe' => $orcamento->total_equipe, 'valor_inicial' => $orcamento->valor_inicial, 'valor_final' => $orcamento->valor_inicial]);

        return redirect('/dashboard')->with('msg','Orçamento criado com sucesso!');
    }

    public function destroy($id) {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->diarias()->detach();
        $orcamento->equipes()->detach();
        $orcamento->materials()->detach();
        $orcamento->delete();

        return redirect('/dashboard')->with('msg', 'Orçamento excluído com sucesso!');
        
    }
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

    public function status(Request $request) {

        Orcamento::findOrFail($request->id)->update([ 'status' => $request->status]);

        return redirect('/dashboard');
    }

    public function razao_status(Request $request) {

        Orcamento::findOrFail($request->id)->update([ 'razao_status' => $request->razao_status]);

        return redirect('/dashboard');
    }
}
