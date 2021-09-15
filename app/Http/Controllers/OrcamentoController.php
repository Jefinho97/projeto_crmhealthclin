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
use mysqli;

class OrcamentoController extends Controller
{
    
    public function index() {
        
        $user = auth()->user();
        if($user != NULL ) {
        return view('dashboard');
        }

        return view('auth.login');

    }
    
    public function dashboard() {
        $user = auth()->user();

        $events = $user->events;

        return view('events.dashboard', ['events' => $events]);
        
    }

    public function create(){

        $materials = Material::all();
        $diarias = Diaria::all();
        $equipes = Equipe::all();
        $soma1 = 0;
        $var1 = 0;
        $tipo = 0;

        return view('orcamentos.create', ['materials' => $materials, 'diarias' => $diarias, 'equipes' => $equipes, 'tipo' => $tipo,'soma1' => $soma1, 'var1'=> $var1]);
    }

    //public function materiais(){
       // return view('orcamentos.materiais');
   // }
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
        $orcamento->valor_inicial = $request->valor_inicial;
        $orcamento->tipo = $request->tipo;
        
        
        $user = auth()->user();
        $orcamento->user_id = $user->id;
        
        if($request->tipo == 0){
            
            $orcamento->save();
            
            return redirect('/dashboard')->with('msg','Evento criado com sucesso!');

        } else {

            $orcamento->save();
            $orcamento= Orcamento::all()->last();

            return view('orcamentos.equipeMedica', ['orcamento' =>$orcamento]);
     
        }
    
    }

}
