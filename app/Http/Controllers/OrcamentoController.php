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

        return view('orcamentos.dashboard', ['orcamentos' => $orcamentos, 'quant' => $quant]);
        
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
            
            $q = $request->quant_mat[$mat];
            $soma_custo = $material->custo * $q;
            $soma_venda = $material->venda * $q;
            $orcamento->total_material += $soma_custo;

            $orcamento->materials()->attach($material->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
        }

        $quant = (is_array($diarias) ? count($diarias) : 0);

        for ($dia=0; $dia < $quant; $dia++) { 
            $diaria = Diaria::findOrFail($diarias[$dia]);
            $orcamento->total_diaria += $diaria->venda;

            $orcamento->diarias()->attach($diaria->id);
        }

        $orcamento->update(['total_material' => $orcamento->total_material, 'total_diaria' => $orcamento->total_diaria]);

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
            $equipe = Material::findOrFail($equipes[$equ]);
            
            $q = $request->quant_equ[$equ];
            $soma_custo = $equipe->custo * $q;
            $soma_venda = $equipe->venda * $q;
            $orcamento->total_equipe += $soma_venda;

            $orcamento->equipes()->attach($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
        }
        $orcamento->valor_inicial = $orcamento->total_material 
        + $orcamento->total_diaria + $orcamento->total_equipe + $orcamento->preco_medico; 

        $orcamento->update(['medico' => $request->medico, 'preco_medico' => $request->preco_medico, 'total_equipe' => $orcamento->total_equipe, 'valor_inicial' => $orcamento->valor_inicial]);

        return redirect('/dashboard')->with('msg','Orçamento criado com sucesso!');
    }

    public function destroy($id) {
        $orcamentos = Orcamento::findOrFail($id);
        $orcamentos->diarias()->detach();
        $orcamentos->equipes()->detach();
        $orcamentos->materials()->detach();
        $orcamentos->delete();

        return redirect('/dashboard')->with('msg', 'Orçamento excluído com sucesso!');
        
    }

}
