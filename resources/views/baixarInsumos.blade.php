@extends('adminlte::page')

@section('title', 'Baixa de Insumos')

@section('content')

<div class="container-fluid">
  @section('content_header')
          <h1>Baixar Insumos<h1>
  @endsection

   
    @foreach($insumos as $i)   
    <form method="POST" action="{{ route('createBaixasInsumos', $i->id) }}" enctype="multipart/form-data">
    {!! method_field('put') !!}
    @endforeach
      {{ csrf_field() }}

    <div class="row" style="margin-left: 300px;">
        <div class="col-sm-4">
            <div class="form-group">
              <label for="insumos_id">Insumo</label>
              <select id="insumos_id" name="insumos_id" class="form-control" onChange="setQuant()">
                    @foreach($insumos as $i)
                    <option value="{{$i->id}}" 
                        {{ ((isset($reg) and $reg->insumos_id == $i->id) or 
                                 old('insumos_id') == $i->id) ? "selected" : "" }}>
                              {{$i->nome}}</option>
                              @endforeach
                            </select>  
            </div>
          </div>
      <div class="col-sm-2">
        <div class="form-group">
          <label for="quant">Baixar Estoque</label>
          <input type="number" onkeypress="return event.charCode >= 1000" min="0" max="0" id="quant" name="quant" 
           class="form-control">
        </div>
      </div>
    </div>
    <div class="row" style="margin-left: 300px;">
      <div class="col-sm-4">
        <div class="form-group">
          <label for="motivo">Motivo</label>
          <input type="text" id="motivo" name="motivo" class="form-control">             
        </div>
      </div>
    </div>

    <div style="margin-left: 540px;">
    <input type="submit" value="Enviar" class="btn btn-success">
    <input type="reset" value="Limpar" class="btn btn-warning">
</div>

    </form>
  </div>

<br>

<table class="table table-hover" id="tabela">
  <tr>
    <th>Insumo</th>
    <th>Motivo</th>
    <th>Quantidade</th>
    <th>Data</th>
    <th>Ações</th>
  </tr>
  
  @forelse ($baixarInsumos as $bi)
  <tr id="tabelaResultado">
    <td> {{$bi->insumos->nome}} </td>
    <td> {{$bi->motivo}} </td>
    <td> {{$bi->quant}} </td>
    <td> {{date_format($bi->created_at, 'd/m/Y')}} </td>
    <td> 
        <form style="display: inline-block"
              method="post"
              action="{{route('destroyBaixasInsumos', $bi->id)}}"
              onsubmit="return confirm('Confirma Exclusão?')">
               {{method_field('delete')}}
               {{csrf_field()}}
              <button type="submit" title="Excluir"
                      class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
        </form>            
    </td>
    
    @empty
    <tr id="vazio"><td colspan=8> Não há insumos baixados</td></tr>
    
    @endforelse
{{ $baixarInsumos->links() }}
    
</table>  

<script>
//pega o elemento insumos_id
  var inputBaixarInsumos = document.getElementById("insumos_id");
  //pega a quant
  var inputQuant = document.getElementById("quant");

// cria o vetor
  var quantsInsumos = [];

<?php
// cria o indice 0
  $indiceVetor = 0;

  foreach ($insumos as $insumo) {
    // pega a quant do vetor
    echo "\nquantsInsumos[".$indiceVetor."] = ".$insumo->quant.";";
    $indiceVetor++;
  }
?>

// seta a quant inicial
setQuant();

function setQuant() {
  var pos = inputBaixarInsumos.selectedIndex;
  inputQuant.max = quantsInsumos[pos];
  inputQuant.value = quantsInsumos[pos];
}

 </script>

@endsection
