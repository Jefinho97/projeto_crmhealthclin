@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Orçamentos Cadastrados</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( $quant > 0)
    <table class="table table-hover" id="orcamento-table">   
        <thead>
            <tr>
                <th scope="col"> 
                    <form method="POST">
                        @csrf
                        <input type="hidden" value="{{ $ordem <> (0 or null)? 0 : 1 }}" name="num_ordem" id="num_ordem">
                        <input type="button" value="Data" id="ordem" name="ordem">
                    </form>
                </th>
                <th scope="col">
                    <form method="POST">
                        @csrf
                        <input type="hidden" value="{{ $ordem <> (2 or null)? 2 : 3 }}" name="num_ordem" id="num_ordem">
                        <input type="button" value="Procedimento" id="ordem" name="ordem">
                    </form>
                </th>
                <th scope="col">Status</th>
                <th scope="col">Razão do Status</th>
                <th scope="col" colspan="2" style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orcamentos as $orcamento)
                <tr>
                    <td scope="row">{{ date('d/m/y', strtotime($orcamento->data)) }}</td>
                    <td><a href="{{ route('orcamentos.show',[$orcamento->id]) }}">{{ $orcamento->procedimento }}</a></td>
                    <td>
                        <form action="{{ route('orcamentos.status',[$orcamento->id]) }}" method="POST">
                        @csrf
                        @method('PUT')  
                            <input type="hidden" name="ordem" id="ordem" value="{{ $ordem }}">
                            <select name="status" id="status" class="form-control" onchange="this.form.submit()"> 
                                <option value="----">----</option>
                                <option value="novo" {{ $orcamento->status === "novo"? "selected" :"" }}>Novo</option>
                                <option value="aguardando" {{ $orcamento->status === "aguardando"? "selected" : "" }}>Aguardando</option>
                                <option value="em andamento" {{ $orcamento->status === "em andamento"? "selected" : "" }}>Em andamento</option>
                                <option value="cancelado" {{ $orcamento->status === "cancelado"? "selected" : "" }}>Cancelado</option>
                                <option value="ganho" {{ $orcamento->status === "ganho"? "selected" : "" }}>Ganho</option>
                                <option value="perdido" {{ $orcamento->status === "perdido"? "selected" : "" }}>Perdido</option>
                                <option value="desistencia" {{ $orcamento->status === "desistencia"? "selected" : "" }}>Desistencia</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('orcamentos.razao_status',[$orcamento->id]) }}" method="POST">
                        @csrf
                        @method('PUT')  
                            <input type="hidden" name="ordem" id="ordem" value="{{ $ordem }}">
                            <select name="razao_status" id="razao_status" class="form-control" onchange="this.form.submit()" > 
                                <option value="----">----</option>
                                <option value="na fila" {{ $orcamento->razao_status === "na fila"? "selected" :"" }}>Na fila para atendimento</option>
                                <option value="aguardando cliente" {{ $orcamento->razao_status === "aguardando cliente"? "selected" : "" }}>Aguardando cliente</option>
                                <option value="aguardando envio" {{ $orcamento->razao_status === "aguardando envio"? "selected" : "" }}>Aguardando envio do cirurgião</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('orcamentos.edit', [$orcamento->id]) }}" class="btn btn-info edit-btn "> Editar </a> 
                    </td>
                    <td>    
                        <button class="btn btn-sm btn-danger" data-id="{{ $orcamento->id }}" id="destroy">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Não há nenhum orçamento cadastrado, <a href="{{ route('orcamentos.create') }}"> criar orçamento</a></p>
    @endif
</div>
@extends('layouts.scripts')
<script>
    toastr.options.preventDuplicates = true;

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function(){
            
        $(document).on('click','#destroy', function(){
            var orcamento_id = $(this).data('id');
            var url = '{{ route("orcamentos.destroy") }}';
            swal.fire({
                    title:'Excluir Orçamento?',
                    html:'Tem certeza que quer  <b>deletar</b> this country',
                    showCancelButton:true,
                    showCloseButton:true,
                    cancelButtonText:'Cancelar',
                    confirmButtonText:'Confirmar',
                    cancelButtonColor:'#d33',
                    confirmButtonColor:'#556ee6',
                    width:300,
                    allowOutsideClick:false
            }).then(function(result){
                if(result.value){
                    $.post(url,{orcamento_id:orcamento_id}, function(data){
                        if(data.code == 1){
                            document.location.reload(true);
                            toastr.success(data.msg);
                        }else{
                            toastr.error(data.msg);
                        }
                    },'json');
                }
            });
        });
    });
</script>
@endsection