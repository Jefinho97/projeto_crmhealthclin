<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diaria;

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
}
