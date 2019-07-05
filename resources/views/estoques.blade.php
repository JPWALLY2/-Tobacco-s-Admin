@extends('adminlte::page')

@section('title', 'Cadastro de Classes')


@section('content')

<div class="container-fluid">
    @section('content_header')
    <h1>Cadastro de Estoque de Fumo</h1>
    @endsection
 
    @if ($acao==1)
    <form method="POST" action="{{ route('estoques.store') }}" enctype="multipart/form-data">
  @else ($acao==2)
    <form method="POST" action="{{ route('estoques.update', $reg->id)}}" enctype="multipart/form-data">
    {!! method_field('put') !!}
  @endif   
  {{ csrf_field() }}

  
  <div class="row" style="margin-left: 450px;">
      <div class="col-sm-4">
          <div class="form-group">
            <label for="posicaoFolha">Posição da Folha</label>
            <select id="posicaoFolha" name="posicaoFolha" class="form-control">
                @foreach($posicaoFolhas as $pf)
                  <option value="{{$pf}}"{{isset($reg) && $reg->posicaoFolha == $pf || old('posicaoFolha') == $pf ? "selected":""}}>{{$pf}}</option>
                @endforeach
            </select>  
          </div>
        </div>

  </div>
  <div style="margin-left: 520px;">
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
      <th>Posição da Folha</th>
      <th>Quantidade (Quilos)</th>
      <th>Ações</th>
    </tr>

    @forelse ($estoques as $e)
    <tr id="tabelaResultado">
        <td> {{$e->posicaoFolha}} </td>
        <td> {{number_format($e->quilo, 2, ',', '.')}} </td>
        <td> 
            <a href="{{route('estoques.edit', $e->id)}}" 
                class="btn btn-warning btn-sm" title="Alterar"
                role="button"><i class="fa fa-edit"></i></a>
                <form style="display: inline-block"
                  method="post"
                  action="{{route('estoques.destroy', $e->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>     
        @if ($loop->iteration == $loop->count)
        <tr><td colspan=8>Total de quilos no estoque : 
                          {{number_format($soma, 2, ',', '.')}}                                   
                        </td></tr>
        @endif                    
    @empty
      <tr id="vazio"><td colspan=8> Não há estoque de fumo </td></tr>
    @endforelse

</table>  

{{ $estoques->links() }}
@stop
 