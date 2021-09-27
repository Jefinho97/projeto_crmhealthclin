@extends('layouts.main')

@section('title', 'Criar Orçamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Equipe Médica</h1>
    <form action="/orcamentos/2" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" id="id" name="id" value="{{ $orcamento->id }}">
        <div class="form-group">
            <label for="title">Medico:</label>
            <input type="text" class="form-control" id="medico" name="medico" placeholder="Nome do médico:">
            <input type="double" class="form-control" id="preco_medico" name="preco_medico" placeholder="Preço do médico">
        </div>
        <div class="form-group" id="form-prof">
            <label for="title">Profissionais:</label>
            <button type="button" class="clonar"> + </button>
            <div class="clone-form-prof">
                <select name="equipes[]" id="equipes" class="form-control">
                    <option>----</option>
                    @foreach($equipes as $equipe)
                    <option value="{{ $equipe->id }}">{{ $equipe->funcao }}</option>
                    @endforeach
                </select>
                <label for="title">Quantidade:</label>
                <input type="int" class="form-control" name="quant_equ[]" id="quant_equ">
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Adicionar ao Orcamento">
    </form>
</div>

<script>
    // clone profissionais 
    $(".clonar").click(function() {
        $(".clone-form-prof").last().clone().appendTo("#form-prof");
    });
</script>

@endsection