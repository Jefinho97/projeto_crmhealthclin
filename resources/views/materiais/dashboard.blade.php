@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Materiais Cadastrados</h1> <a href="/materiais/create"> cadastrar material</a>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( $quant > 0)
    <table class="table">   
        <thead>
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Nome</th>
                <th scope="col">Unidade de Medida</th>
                <th scope="col">Custo do Produto</th>
                <th scope="col">Preço de Venda</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materiais as $material)
                <tr>
                    <td>{{ $material->tipo }}</td>
                    <td>{{ $material->nome }}</a></td>
                    <td>{{ $material->uni_medida}}</td>
                    <td>{{ $material->custo }}</td>
                    <td>{{ $material->venda }}</td>
                    <td>
                        <a href="/materiais/edit/{{ $material->id }}" class="btn btn-info edit-btn "><ion-icon name="create-outline"></ion-icon> Editar </a> 
                    </td>
                    <td>    
                        <form action="/materiais/{{ $material->id }}" method="POST">
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
    <p>Não há nenhum material cadastrado, <a href="/materiais/create"> cadastrar material</a></p>
    @endif
</div>
@endsection