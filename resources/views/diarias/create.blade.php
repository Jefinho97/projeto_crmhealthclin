@extends('layouts.main')

@section('title', 'Criar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Cadastrar Diaria</h1>
    <form action="/diarias" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao">
        </div>
        <div class="form-group">
            <label for="title">Preço base:</label>
            <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo">
        </div>
        <div class="form-group">
            <label for="title">Preço final:</label>
            <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda">
        </div>
                    
        <input type="submit" class="btn btn-primary" value="Cadastrar Diaria">
    </form>
</div>
@endsection