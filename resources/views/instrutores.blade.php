@extends('adminlte::page')

@section('title', 'Cadastro de Instrutores')

@section('content')

<div class="container-fluid">
@section('content_header')
    <h1>Cadastro de Instrutores</h1>
@endsection

  @if ($acao==1)
    <form method="POST" action="{{ route('instrutores.store') }}" enctype="multipart/form-data">
  @elseif ($acao==2)
    <form method="POST" action="{{route('instrutores.update', $reg->id)}}" enctype="multipart/form-data">
    {!! method_field('put') !!}
  @endif          
  {{ csrf_field() }}

  <div class="row" style="margin-left: 250px;">
    <div class="col-sm-4">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" autofocus
               value="{{$reg->nome or old('nome')}}"
               class="form-control">
               <strong>{{ $errors->first('nome') }}</strong>                 
      </div>
    </div>

    <div class="col-sm-4">
      <div class="form-group">
        <label for="empresas_id">Empresa</label>
        <select id="empresas_id" name="empresas_id" class="form-control">
          @foreach($empresas as $emp)
            <option value="{{$emp->id}}" 
                    {{ ((isset($reg) and $reg->empresas_id == $emp->id) or 
                       old('empresas_id') == $emp->id) ? "selected" : "" }}>
                    {{$emp->nome}}</option>
          @endforeach
        </select>  
      </div>
    </div>
  </div>              

  <div class="row" style="margin-left: 250px;">
      <div class="col-sm-4">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" id="email" name="email"
                 value="{{$reg->email or old('email')}}"
                 class="form-control">
                <strong>{{ $errors->first('email') }}</strong>
        </div>
      </div>
    
      <div class="col-sm-4">
        <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone"
                   value="{{$reg->telefone or old('telefone')}}"
                   class="form-control">
                   <strong>{{ $errors->first('telefone') }}</strong>
                  </div>
      </div>
  </div>
<div style="margin-left: 655px;">
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
      <th>Empresa</th>
      <th>Email</th>
      <th>Telefone</th>
      <th>Ações</th>
    </tr>
    @forelse ($instrutores as $i)
      <tr id="tabelaResultado">
        <td> {{$i->nome}} </td>
        <td> {{$i->empresas->nome}} </td>
        <td> {{$i->email}} </td>
        <td> {{$i->telefone}} </td>
        <td> 
            <a href="{{route('instrutores.edit', $i->id)}}" 
                class="btn btn-warning btn-sm" title="Alterar"
                role="button"><i class="fa fa-edit"></i></a>
            <form style="display: inline-block"
                  method="post"
                  action="{{route('instrutores.destroy', $i->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
            
    @empty
      <tr id="vazio"><td colspan=8> Não há instrutores cadastrados </td></tr>
    @endforelse

</table>  
{{ $instrutores->links() }}
@stop

@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#telefone').mask('000000000', {reverse: true});
    });
  </script> 
  @endsection