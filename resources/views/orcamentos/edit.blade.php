@extends('layouts.main')

@section('title', 'Criar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editar Orçamento</h1>
    <form action="/orcamentos/update/{{ $orcamento->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Procedimento:</label>
            <input type="text" class="form-control" id="procedimento" name="procedimento" value="{{ $orcamento->procedimento }}">
        </div>

        @if($orcamento->tipo == true)
        <div class="form-group">
            <label for="title">Medico:</label>
            <input type="text" class="form-control" id="medico" name="medico" value="{{ $orcamento->medico }}">
            <input type="double" class="form-control" id="preco_medico" name="preco_medico" value="{{ $orcamento->preco_medico }}">
        </div>
        
        <div class="form-group">
            <label for="title">Profissionais:</label>
            @foreach($orcamento->equipes as $orcequ)
            <select name="equipes[]" id="equipes" class="form-control">
                @foreach($equipes as $equipe)
                @if($equipe->id == $orcequ->pivot->equipe_id)
                <option value="{{ $equipe->id }}" selected>{{ $equipe->funcao }}</option>
                @else
                <option value="{{ $equipe->id }}">{{ $equipe->funcao }}</option>
                @endif
                @endforeach
            </select>
            <label for="title">Quantidade:</label>
            <input type="int" class="form-control" name="quant_equ[]" id="quant_equ" value="{{ $orcequ->pivot->quant}}">
            @endforeach
        </div>
        @endif
        <div class="form-group">
            <label for="title">Materiais e Medicamentos:</label>
            @foreach($orcamento->materials as $orcmat)
            <select name="materials[]" id="materials" class="form-control">
                @foreach($materials as $material)
                @if($material->id == $orcmat->pivot->material_id)
                <option value="{{ $material->id }}" selected>{{ $material->nome }}</option>
                @else
                <option value="{{ $material->id }}">{{ $material->nome }}</option>
                @endif
                @endforeach
            </select>
            <label for="title">Quantidade:</label>
            <input type="int" class="form-control" name="quant_mat[]" id="quant_mat" value="{{ $orcmat->pivot->quant}}">
            @endforeach
        </div>       

        <div class="form-group">
            <label for="title">Diarias:</label>
            @foreach($orcamento->diarias as $orcdia)
            <select name="diarias[]" id="diarias" class="form-control">
                @foreach($diarias as $diaria)
                @if($diaria->id == $orcdia->pivot->diaria_id)
                <option value="{{ $diaria->id }}" selected>{{ $diaria->descricao }}</option>
                @else
                <option value="{{ $diaria->id }}">{{ $diaria->descricao }}</option>
                @endif
                @endforeach
            </select>
            @endforeach
        </div>

        <label for="title">Informações do Paciente {{ $orcamento->paciente}}:</label>
        <div class="form-group">
            <input type="text" class="form-control" id="paciente" name="paciente" value="{{ $orcamento->paciente }}">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="email_pac" name="email_pac" value="{{ $orcamento->email_pac}}">
        </div>
        <div class="form-group">    
            <input type="tel" class="form-control" id="telefone_1" name="telefone_1" value="{{ $orcamento->telefone_1 }}">
        </div>
        <div class="form-group">    
            <input type="tel" class="form-control" id="telefone_2" name="telefone_2" value="{{ $orcamento->telefone_2 }}">
        </div>
        
        <div class="form-group">
            <label for="date">Data do Procedimento:</label>
            <input type="date" class="form-control" id="data" name="data" value="{{ $orcamento->data->format('Y-m-d') }}">
        </div>
        <div class="form-group">
            <label for="title">Termos e condições:</label>
            <textarea name="termos_condicoes" id="termos_condicoes" class="form-control">{{ $orcamento->termos_condicoes }}</textarea>    
        </div>
        <div class="form-group">
            <label for="title">Convenios:</label>
            <textarea name="convenios" id="convenios" class="form-control" >{{ $orcamento->convenios }}</textarea>    
        </div>
        <div class="form-group">
            <label for="title">Condições de pagamento:</label>
            <textarea name="condicoes_pag" id="condicoes_pag" class="form-control">{{ $orcamento->condicoes_pag }}</textarea>    
        </div>
        <input type="hidden" id="valor_final" name="valor_final" value="{{ $orcamento->valor_final }}">
        <input type="submit" class="btn btn-primary" value="Editar Orcamento">
    </form>
</div>
@endsection