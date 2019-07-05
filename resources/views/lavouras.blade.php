@extends('adminlte::page')

@section('title', 'Cadastro de Lavouras')


@section('content')

<div class="container-fluid">

    @section('content_header')
    <h1>Cadastro de Lavouras</h1>
@endsection

    @if ($acao==1)
      <form method="POST" action="{{ route('lavouras.store') }}" enctype="multipart/form-data">
    @else ($acao==2)
      <form method="POST" action="{{ route('lavouras.update', $reg->id)}}" enctype="multipart/form-data">
      {!! method_field('put') !!}
    @endif          
    {{ csrf_field() }}

    
    <div class="row" style="margin-left: 250px;">
      <div class="col-sm-5">
        <div class="form-group">
          <label for="descricao">Nome ou Descrição</label>
          <input type="text" id="descricao" name="descricao" autofocus
                 value="{{$reg->descricao or old('descricao')}}"
                 class="form-control">
            <strong>{{ $errors->first('descricao') }}</strong>                 
        </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group">
          <label for="hectares">Hectares</label>
          <input type="text" id="hectares" name="hectares"
                 value="{{$reg->hectares or old('hectares')}}"
                 class="form-control">
            <strong>{{ $errors->first('hectares') }}</strong>                 
        </div>
      </div>
    </div>
    
    

    <div style="margin-left: 585px;">
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
      <th>Nome ou Descrição</th>
      <th>Hectares</th>
      <th>Ações</th>
    </tr>
    @forelse ($lavouras as $l)
    <tr id="tabelaResultado">
        <td> {{$l->descricao}} </td>    
        <td> {{number_format($l->hectares, 1, '.', '.')}} </td>    
        
        <td> 
            <a href="{{route('lavouras.edit', $l->id)}}" 
                class="btn btn-warning btn-sm" title="Alterar"
                role="button"><i class="fa fa-edit"></i></a>
            <form style="display: inline-block"
                  method="post"
                  action="route('lavouras.destroy', $l->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
        @if ($loop->iteration == $loop->count)
             <tr><td colspan=8>Nº de Lavouras: {{$numLavouras}}                              
                              </td></tr>
                            
        @endif        
    @empty
      <tr id="vazio"><td colspan=8> Não há lavouras cadastradas </td></tr>
    @endforelse

</table>  

{{ $lavouras->links() }}
@stop

@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#hectares').mask('##.0', {reverse: true});
    });
  </script> 
  @endsection