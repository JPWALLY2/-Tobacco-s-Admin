@extends('adminlte::page')

@section('title', 'Cadastro de Marcas')


@section('content')

<div class="container-fluid">

    @section('content_header')
    <h1>Cadastro de Marcas</h1>
@endsection

@if ($acao==1)
<form method="POST" action="{{ route('marcas.store') }}" enctype="multipart/form-data">
  @else ($acao==2)
      <form method="POST" action="{{ route('marcas.update', $reg->id)}}" enctype="multipart/form-data">
      {!! method_field('put') !!}
    @endif          
    {{ csrf_field() }}
    
    <div class="row" style="margin-left: 450px;">
      <div class="col-sm-4">
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" id="nome" name="nome" autofocus
                 value="{{$reg->nome or old('nome')}}"
                 class="form-control">
            <strong>{{ $errors->first('nome') }}</strong>                 
        </div>
      </div>
    </div>
    
    

    <div style="margin-left: 516px;">
    <input type="submit" value="Enviar" class="btn btn-success">
    <input type="reset" value="Limpar" class="btn btn-warning">
</div>

    </form>
  </div>

  <br>
  @if (session('status'))
<div class="alert-danger" style="text-align: center">
      {{ session('status') }}
    </div>  
    <script>
        setTimeout(function(){ 
            var msg = document.getElementsByClassName("alert-danger");
            while(msg.length > 0){
                msg[0].parentNode.removeChild(msg[0]);
            }
        }, 3000);
    </script>
@endif

<table class="table table-hover" id="tabela">
    <tr>
      <th>Nome</th>
      <th>Ações</th>
    </tr>
    @forelse ($marcas as $m)
    <tr id="tabelaResultado">
        <td> {{$m->nome}} </td>  
        
        <td> 
            <a href="{{route('marcas.edit', $m->id)}}" 
                class="btn btn-warning btn-sm" title="Alterar"
                role="button"><i class="fa fa-edit"></i></a>
            <form style="display: inline-block"
                  method="post"
                  action="{{route('marcas.destroy', $m->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
        @if ($loop->iteration == $loop->count)
             <tr><td colspan=8>Nº de Marcas trabalhadas: {{$numMarcas}}                              
                              </td></tr>
                            
        @endif        
    @empty
      <tr id="vazio"><td colspan=8> Não há marcas cadastradas </td></tr>
    @endforelse

</table>  

{{ $marcas->links() }}
@stop
