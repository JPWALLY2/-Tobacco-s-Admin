@extends('adminlte::page')

@section('title', 'Cadastro de Tipos de Insumos')

@section('content')

<div class="container-fluid">
  @section('content_header')
  <h2>Cadastro de Tipos de Insumos</h2>
@endsection

  @if ($acao==1)
    <form method="POST" action="{{ route('tiposInsumos.store') }}" enctype="multipart/form-data">
  @else ($acao==2)
    <form method="POST" action="{{ route('tiposInsumos.update', $reg->id)}}" enctype="multipart/form-data">
    {!! method_field('put') !!}
  @endif          
  {{ csrf_field() }}

  
  <div class="row" style="margin-left: 375px;">
    <div class="col-sm-5">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" autofocus
               value="{{$reg->nome or old('nome')}}"
               class="form-control">
               <strong>{{ $errors->first('nome') }}</strong>

      </div>
    </div>
  </div>
  

  <div style="margin-left: 515px;">
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
    <th> Tipo </th>
    <th> Ações </th>
  </tr>  
@forelse($tiposInsumos as $ti)
  <tr id="tabelaResultado">
    <td> {{$ti->nome}} </td>  
    <td> 
        <a href="{{route('tiposInsumos.edit', $ti->id)}}" 
            class="btn btn-warning btn-sm" title="Alterar"
            role="button"><i class="far fa-edit"></i></a>
        <form style="display: inline-block"
              method="post"
              action="{{route('tiposInsumos.destroy', $ti->id)}}"
              onsubmit="return confirm('Confirma Exclusão?')">
               {{method_field('delete')}}
               {{csrf_field()}}
              <button type="submit" title="Excluir"
                      class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
        </form>            
    </td>
  </tr>

@empty
  <tr id="vazio"><td colspan=8> Não há tipos de insumos cadastrados</td></tr>
@endforelse
</table>
{{ $tiposInsumos->links() }}
@endsection
