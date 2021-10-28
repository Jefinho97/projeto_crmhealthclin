@extends('layouts.main')

@section('title', 'Criar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Cadastrar Profissional</h1>
    <form action="{{ route('equipes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Função:</label>
            <input type="text" class="form-control" id="funcao" name="funcao">
        </div>
        <div class="form-group">
            <label for="title">Custo:</label>
            <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo">
        </div>
        <div class="form-group">
            <label for="title">Preço final:</label>
            <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda">
        </div>
                    
        <input type="submit" class="btn btn-primary" value="Cadastrar Profissional">
    </form>
</div>
@endsection