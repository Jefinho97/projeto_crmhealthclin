@extends('layouts.main')

@section('title', 'Criar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Adicionar materiais</h1>
    <form action="/materiais" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Tipo:</label>
            <select name="tipo" id="tipo" class="form-control"> 
                <option value="----" selected>----</option>
                <option value="material">Material</option>
                <option value="medicamento">Medicamento</option>
                <option value="dieta">Dieta</option>
                <option value="equipamento">Equipamento</option>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome">
        </div>
        <div class="form-group">
            <label for="title">Unidade de Medida:</label>
            <input type="text" class="form-control" id="uni_medida" name="uni_medida">
        </div>
        <div class="form-group">
            <label for="title">Custo do Produto:</label>
            <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo">
        </div>
        <div class="form-group">
            <label for="title">Preço da venda:</label>
            <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda">
        </div>
                    
        <input type="submit" class="btn btn-primary" value="Adicionar materiais">
    </form>
</div>
@endsection