@extends('adminlte::page')

@section('title', 'Cadastro de Insumos Comprados')

@section('content')

   <div class="container-fluid">
      @section('content_header')
      <h2>Itens Comprados</h2>

  @endsection

       <form method="POST" action="{{ route('createItensComprados',$reg->id) }}" enctype="multipart/form-data">
               
    {{ csrf_field() }}
   
    <div class="row" style="margin-left: 250px;">
      <div class="col-sm-3">
        <div class="form-group">
          <label for="insumos_id">Insumo</label>
          <select id="insumos_id" name="insumos_id" class="form-control">
                @foreach($insumos as $i)
                <option value="{{$i->id}}" 
                    {{ ((isset($reg) and $reg->insumo == $i->id) or 
                     old('insumo') == $i->id) ? "selected" : "" }}>
                {{$i->nome}}</option>
                @endforeach
          </select>  
        </div>
      </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="preco">Preço</label>
            <input type="text" id="preco" name="preco"  onkeypress="return event.total"
                 value="{{$reg->preco or old('preco')}}"
                 class="form-control">
            <strong>{{ $errors->first('preco') }}</strong>                 

          </div>
        </div>
          <div class="col-sm-2">
            <div class="form-group">
                <label for="quant">Quantidade</label>
                <input type="number" min="0" id="quant" name="quant" 
                 value="{{$reg->quant or old('quant')}}"
                 class="form-control">
            <strong>{{ $errors->first('quant') }}</strong>                 

            </div>
          </div>
        </div>
        <div class="col-sm-2">
              <input type="hidden" id="total" name="total"
              value="{{$reg->total}}" class="form-control">
        </div>
        <div class="col-sm-2">
              <input type="hidden" id="calc" name="calc"
              value="" class="form-control">
        </div>

    <div style="margin-left: 668px;">
       <input type="submit" value="Enviar" class="btn btn-success">
       <input type="reset" value="Limpar" class="btn btn-warning">
    </div>
  </form>
</div>

<br>
<a href="{{ route('compras.index') }}"
class="btn btn-primary pull-right " title="Voltar" role="button"><i class="fas fa-arrow-circle-left"></i></a>
<br>
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
    <thead>
      <tr>
        <th>Insumo</th>
        <th>Quantidade</th>
        <th>Preço</th>
        <th>Sub Total</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      
      @forelse ($itenscompras as $ic)
      <tr id="tabelaResultado">
        <td> {{$ic->insumos->nome}} </td>
        <td> {{$ic->quant}} </td>
        <td> {{number_format($ic->preco, 2, ',', '.')}} </td>
        <td> {{number_format($ic->total, 2, ',', '.')}} </td>
        <td> 
            <form style="display: inline-block"
                  method="post"
                  action="{{route('destroytensComprados', $ic->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
          @if ($loop->iteration == $loop->count)
             <tr><td colspan=8>Total dos itens comprados R$: 
                               {{number_format($soma, 2, ',', '.')}}
                              ---- Nº de Compras: {{$numIC}}                              
                              </td></tr>                    
        @endif 
        
        @empty
        <tr id="vazio"><td colspan=8> Não há insumos comprados </td></tr>
        
        @endforelse
        
      </tbody>
    </table> 
{{ $itenscompras->links() }}

    @stop

@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>
  
   
  <script>
    $(document).ready(function() {
      $('#preco').mask('#.###.##0,00', {reverse: true});
    });
  </script>   

  <script>
$(document).ready(function(){

$("input").change(function(){

precoV = $("input[name=preco]").val();
precoP = precoV.replace(".", "");
precoP1 = precoP.replace(",", ".");

//pegando os numeros dos campos inputs
quant = parseInt($("input[name=quant]").val());
preco = parseFloat(precoP1);

//formula para cálculo do total
total = (preco * quant);

//mostrar o resultado no input name=calc
$("input[name=calc]").val(total);

return false;
});
});
  </script>
  @endsection
