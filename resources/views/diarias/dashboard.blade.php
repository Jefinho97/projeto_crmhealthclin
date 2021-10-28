@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Diarias Cadastradas</h1> <a href="{{ route('diarias.create') }}"> cadastrar diaria</a>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( $quant > 0)
    <table class="table">   
        <thead>
            <tr>
                <th scope="col">Descrição</th>
                <th scope="col">Custo</th>
                <th scope="col">Venda</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($diarias as $diaria)
                <tr>
                    <td>{{ $diaria->descricao }}</td>
                    <td>{{ $diaria->custo }}</td>
                    <td>{{ $diaria->venda }}</td>
                    <td>
                        <a href="{{ route('diarias.edit', [$diaria->id]) }}" class="btn btn-info edit-btn "><ion-icon name="create-outline"></ion-icon> Editar </a> 
                    </td>
                    <td>    
                        <form action="{{ route('diarias.destroy', [$diaria->id]) }}" method="POST">
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
    <p>Não há nenhuma diaria cadastrada, <a href="{{ route('diarias.create') }}"> cadastrar diaria</a></p>
    @endif
</div>
@endsection