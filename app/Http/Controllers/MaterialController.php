<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function create(){

        return view('materials.create');

    }

    
    public function store(Request $request) {
        
        $material = new Material;

        $material->tipo = $request->tipo;
        $material->nome = $request->nome;
        $material->uni_medida = $request->uni_medida;
        $material->custo = $request->custo;
        $material->venda = $request->venda;
           
        $material->save();
 
            return redirect('/dashboard')->with('msg','Função criado com sucesso!');

    }

    public function destroy($id) {
        Material::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Diaria excluída com sucesso!');
        
    }
}
