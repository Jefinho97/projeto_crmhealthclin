@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Orçamentos Cadastrados</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( $quant > 0)
    <table class="table">   
        <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Procedimento</th>
                <th scope="col">Status</th>
                <th scope="col">Razão do Status</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orcamentos as $orcamento)
                <tr>
                    <td>{{ date('d/m/y', strtotime($orcamento->data)) }}</td>
                    <td><a href="/orcamentos/{{ $orcamento->id }}">{{ $orcamento->procedimento }}</a></td>
                    <td>{{ $orcamento->status }}</td>
                    <td>{{ $orcamento->razao_status }}</td>
                    <td>
                        <a href="/orcamentos/edit/{{ $orcamento->id }}" class="btn btn-info edit-btn "><ion-icon name="create-outline"></ion-icon> Editar </a> 
                    </td>
                    <td>    
                        <form action="/orcamentos/{{ $orcamento->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn"><ion-icon name="trash-outline"></ion-icon> Deletar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Não há nenhum orçamento cadastrado, <a href="/orcamentos/create"> criar orçamento</a></p>
    @endif
</div>
@endsection