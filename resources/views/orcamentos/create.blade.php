@extends('layouts.main')

@section('title', 'Criar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Crie o seu Orçamento</h1>
    <form action="/orcamentos" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Procedimento:</label>
            <input type="text" class="form-control" id="procedimento" name="procedimento" placeholder="Qual o procedimento?">
        </div>
        
        <div class="form-group" id="form-mat">
            <label for="title">Materiais e Medicamentos:</label>
            <button type="button" class="clonar"> + </button>
            <div class="clone-form-mat">   
                <select name="materials[]" id="materials" class="form-control">
                    <option>----</option>
                    @foreach($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->nome }}</option>
                    @endforeach
                </select>
                <label for="title">Quantidade:</label>
                <input type="int" class="form-control" name="quant_mat[]" id="quant_mat">
            </div>
        </div>       

        <div class="form-group" id="form-dia">
            <label for="title">Diarias:</label>
            <button type="button" class="clonar2"> + </button>
            <div class="clone-form-dia">
                <select name="diarias[]" id="diarias" class="form-control">
                    <option>----</option>
                    @foreach($diarias as $diaria)
                    <option value="{{ $diaria->id }}">{{ $diaria->descricao }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <label for="title">Informações do Paciente:</label>
        <div class="form-group">
            <input type="text" class="form-control" id="paciente" name="paciente" placeholder="Nome do Paciente">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="email_pac" name="email_pac" placeholder="E-mail do Paciente">
        </div>
        <div class="form-group">    
            <input type="text" class="form-control" id="telefone_1" name="telefone_1" placeholder="Telefone do Paciente">
        </div>
        <div class="form-group">    
            <input type="text" class="form-control" id="telefone_2" name="telefone_2" placeholder="Telefone Opcional do Paciente">
        </div>
        
        <div class="form-group">
            <label for="date">Data do Procedimento:</label>
            <input type="date" class="form-control" id="data" name="data">
        </div>
        <div class="form-group">
            <label for="title">Termos e condições:</label>
            <textarea name="termos_condicoes" id="termos_condicoes" class="form-control" placeholder="Termos e Condições"></textarea>    
        </div>
        <div class="form-group">
            <label for="title">Convenios:</label>
            <textarea name="convenios" id="convenios" class="form-control" placeholder="Convenios"></textarea>    
        </div>
        <div class="form-group">
            <label for="title">Condições de pagamento:</label>
            <textarea name="condicoes_pag" id="condicoes_pag" class="form-control" placeholder="O que vai acontecer no evento?"></textarea>    
        </div>
        <div class="form-group">
            Orçamento com equipe médica:<input type="checkbox" name="tipo" value="1"> 
        </div>
        <input type="submit" class="btn btn-primary" value="Criar Orcamento">
    </form>
</div>
<script>
    // clone materiais
    $(".clonar").click(function() {
        $(".clone-form-mat").last().clone().appendTo("#form-mat");
    });

    // clone diarias
    $(".clonar2").click(function() {
        $(".clone-form-dia").last().clone().appendTo("#form-dia");
    });
</script>
@endsection