@extends('layouts.main')

@section('title', 'Criar Orçamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Equipe Médica</h1>
    <form action="/orcamentos/{{ $orcamento->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Medico:</label>
            <input type="text" class="form-control" id="medico" name="medico" placeholder="Nome do médico:">
            <input type="double" class="form-control" id="preco_medico" name="preco_medico" placeholder="Preço do médico">
        </div>
        <div class="form-group">
            <label for="title">Profissionais:</label>
            <select name="equipes" id="equipes" class="form-control">
                @foreach($equipes as $equipe)
                <option value="{{ $equipe->id }}">{{ $equipe->funcao }}</option>
                @endforeach
            </select>
            <label for="title">Quantidade:</label>
            <input type="int" class="form-control" name="quantEquipe" id="quantEquipe">
        </div>
        <input type="submit" class="btn btn-primary" value="Adicionar ao Orcamento">
    </form>
</div>

@endsection