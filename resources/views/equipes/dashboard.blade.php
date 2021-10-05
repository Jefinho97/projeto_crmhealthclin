@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Funções Cadastradas</h1> <a href="/equipes/create"> cadastrar função</a>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( $quant > 0)
    <table class="table">   
        <thead>
            <tr>
                <th scope="col">Função</th>
                <th scope="col">Custo</th>
                <th scope="col">Venda</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipes as $equipe)
                <tr>
                    <td>{{ $equipe->tipo }}</td>
                    <td>{{ $equipe->custo }}</td>
                    <td>{{ $equipe->venda }}</td>
                    <td>
                        <a href="/equipes/edit/{{ $equipe->id }}" class="btn btn-info edit-btn "><ion-icon name="create-outline"></ion-icon> Editar </a> 
                    </td>
                    <td>    
                        <form action="/equipes/{{ $equipe->id }}" method="POST">
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
    <p>Não há nenhuma função cadastrada, <a href="/equipes/create"> cadastrar material</a></p>
    @endif
</div>
@endsection