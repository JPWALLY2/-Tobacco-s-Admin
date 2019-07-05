@extends('adminlte::page')

@section('title', 'Cadastro de Classes')


@section('content')

<div class="container-fluid">
    @section('content_header')
    <h1>Cadastro de Classes</h1>
    @endsection
 
    <form method="POST" action="{{ route('classes.store') }}" enctype="multipart/form-data">
         
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
      <th>Nome</th>
      <th>Ações</th>
    </tr>

    @forelse ($classes as $c)
    <tr id="tabelaResultado">
        <td> {{$c->nome}} </td>        
        <td> 
            <form style="display: inline-block"
                  method="post"
                  action="{{route('classes.destroy', $c->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
        @if ($loop->iteration == $loop->count)
             <tr><td colspan=8>Nº de Classes: {{$numClasses}}                              
                              </td></tr>
                            
        @endif        
    @empty
      <tr id="vazio"><td colspan=8> Não há classes cadastradas </td></tr>
    @endforelse

</table>  
{{ $classes->links() }}
@endsection