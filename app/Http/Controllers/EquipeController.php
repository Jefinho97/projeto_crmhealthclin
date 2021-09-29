<?php

namespace App\Http\Controllers;
use App\Models\Equipe;

use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function create(){

        return view('equipes.create');

    }

    
    public function store(Request $request) {
        
        $equipe = new Equipe;

        $equipe->funcao = $request->funcao;
        $equipe->custo = $request->custo;
        $equipe->venda = $request->venda;
           
        $equipe->save();
 
            return redirect('/dashboard')->with('msg','Função criado com sucesso!');

    }
    public function destroy($id) {
        Equipe::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Função excluída com sucesso!');
        
    }
}
