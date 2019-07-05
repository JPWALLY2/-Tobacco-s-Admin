@extends('adminlte::page')

@section('title', 'Listagem de Produção')

@section('content')

<div class="container-fluid">
    @section('content_header')
    <h1>Cadastro de Produção</h1>
    @endsection

    @if ($acao==1)
      <form method="POST" action="{{ route('producoes.store') }}" enctype="multipart/form-data">
    @else ($acao==2)
      {{-- <form method="POST" action="{{route('compras.update', $reg->id)}}" enctype="multipart/form-data"> --}}
      {!! method_field('put') !!}
    @endif          
    {{ csrf_field() }}
    
    
    <div class="row" style="margin-left: 350px;">
        <div class="col-sm-4">
          <div class="form-group">
            <label for="estoques_id">Posição da Folha</label>
            <select id="estoques_id" name="estoques_id" class="form-control">
              @foreach($estoques as $e)
                <option value="{{$e->id}}" 
                        {{ ((isset($reg) and $reg->estoques_id == $e->id) or 
                           old('estoques_id') == $e->id) ? "selected" : "" }}>
                        {{$e->posicaoFolha}}</option>
              @endforeach
            </select>  
          </div>
        </div>
         <div class="col-sm-3">
            <div class="form-group">
                <label for="quilo">Quilo</label>
                <input type="text" id="quilo" name="quilo"
                 value="{{$reg->quilo or old('quilo')}}"
                 class="form-control">           
            </div>
          </div>
      </div>
     
        <div style="margin-left: 703px;">
            <input type="submit" value="Enviar" class="btn btn-success">
        </div>
      </form>
  </div>

  <br>

  <table class="table table-hover" id="tabela">
    <tr>
      <th>Posição da Folha</th>
      <th>Quilo</th>
      <th>Data</th>
      <th>Ações</th>
    </tr>
    @forelse ($producoes as $p)
    <tr id="tabelaResultado">
      <td> {{$p->estoques->posicaoFolha}} </td>        
        <td> {{number_format($p->quilo, 2, ',', '.')}} </td>
        <td> {{date_format($p->created_at, 'd/m/Y')}} </td>
        
        <td>
            <form style="display: inline-block"
                  method="post"
                  action="{{route('producoes.destroy', $p->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
        @if ($loop->iteration == $loop->count)
             <tr><td colspan=8>Total de Quilos: 
                               {{number_format($soma, 2, ',', '.')}}                           
                              </td></tr>                    
        @endif        
    @empty
      <tr id="vazio"><td colspan=8> Não há produção </td></tr>
    @endforelse

</table>  
{{ $producoes->links() }}

@stop

@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>
   
  <script>
    $(document).ready(function() {
      $('#quilo').mask('#.###.##0,00', {reverse: true});
    });
  </script>    
 
  @endsection