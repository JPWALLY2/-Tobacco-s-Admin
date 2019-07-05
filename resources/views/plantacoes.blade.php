@extends('adminlte::page')

@section('title', 'Cadastro de Plantações')

@section('content')

<div class="container-fluid">
    @section('content_header')
    <h1>Cadastro de Plantações</h1>
@endsection

    @if ($acao==1)
      <form method="POST" action="{{ route('plantacoes.store') }}" enctype="multipart/form-data">
    @else ($acao==2)
      <form method="POST" action="{{ route('plantacoes.update', $reg->id)}}" enctype="multipart/form-data">
      {!! method_field('put') !!}
    @endif          
    {{ csrf_field() }}

    
    <div class="row" style="margin-left: 250px;">
      <div class="col-sm-4">
        <div class="form-group">
          <label for="lavouras_id">Qual Lavoura?</label>
          <select id="lavouras_id" name="lavouras_id" class="form-control">
            @foreach($lavouras as $l)
              <option value="{{$l->id}}" 
                      {{ ((isset($reg) and $reg->lavouras_id == $l->id) or 
                         old('lavouras_id') == $l->id) ? "selected" : "" }}>
                      {{$l->descricao}}</option>
            @endforeach
          </select>  
        </div>
      </div>
      <div class="col-sm-4">
        <div class="form-group">
          <label for="quant">Quantidade Plantada</label>
          <input type="text" id="quant" name="quant"
                 value="{{$reg->quant or old('quant')}}"
                 class="form-control">
            <strong>{{ $errors->first('quant') }}</strong>                 
        </div>
      </div>
    </div>
    <div class="row" style="margin-left: 250px;">

      <div class="col-sm-4">
        <div class="form-group">
          <label for="observacao">Observação</label>
          <textarea name="observacao" id="observacao" cols="63,9" rows="5"></textarea> 
        </div>
      </div>
    </div>

    

    <div class="col-sm-4">   
      <input type="hidden" id="users_id" name="users_id"
      value="{{auth()->user()->id}}" class="form-control">
    </div>

    <div style="margin-left: 650px;">
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
      <th>Quantidade Plantada (Mil)</th>
      <th>Observação</th>
      <th>Lavoura</th>
      <th>Data do Plantio</th>
      <th>Ações</th>
    </tr>
    @forelse ($plantacoes as $p)
    <tr id="tabelaResultado">
        <td> {{number_format($p->quant, 2, ',', '.')}} </td> 
        <td> {{$p->observacao}} </td>    
        <td> {{$p->lavouras->descricao}} </td>    
        <td> {{date_format($p->created_at, 'd/m/Y')}} </td>
        
        <td> 
            <a href="{{route('plantacoes.edit', $p->id)}}" 
                class="btn btn-warning btn-sm" title="Alterar"
                role="button"><i class="fa fa-edit"></i></a>
            <form style="display: inline-block"
                  method="post"
                  action="{{route('plantacoes.destroy', $p->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>     
        @if ($loop->iteration == $loop->count)
        <tr><td colspan=8>Total plantado: 
                          {{number_format($soma, 2, ',', '.')}}                            
                         </td></tr>
                       
   @endif   
    @empty
      <tr id="vazio"><td colspan=8> Não há plantações cadastradas </td></tr>
    @endforelse

</table>  

{{ $plantacoes->links() }}
@stop

@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#quant').mask('#.###.##0,00', {reverse: true});
    });
  </script> 
  @endsection