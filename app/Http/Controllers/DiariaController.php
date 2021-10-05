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

class DiariaController extends Controller
{

    public function create(){

        return view('diarias.create');

    }

    
    public function store(Request $request) {
        
        $diarias = new Diaria;

        $diarias->descricao = $request->descricao;
        $diarias->custo = $request->custo;
        $diarias->venda = $request->venda;
           
        $diarias->save();
 
            return redirect('/dashboard')->with('msg','Diaria criado com sucesso!');

    }
    
    public function destroy($id) {
        Diaria::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Diaria excluída com sucesso!');
        
    }

    public function dashboard() {
        
        $user = Auth::user();

        $diarias = $user->diarias;

        $quant = count($diarias);

        return view('diarias.dashboard', ['diarias' => $diarias, 'quant' => $quant]);
        
    }

    public function edit($id) {

        $diaria = Diaria::findOrFail($id);

        return view('diarias.edit', ['diaria' => $diaria]);
    
    }

    public function update(Request $request) {

        Diaria::findOrFail($request->id)->update($request->all());

        return redirect('/diarias/dashboard')->with('msg', 'Diaria editada com sucesso!');
    }
}
