@extends('adminlte::page')

@section('title', 'Estimativa')

@section('content')

   <div class="container-fluid">
     @section('content_header')
         <h1>Estimativa</h1>
     @endsection

      <form method="POST" action="{{ route('estimativas.store') }}" enctype="multipart/form-data">
           
    {{ csrf_field() }}

    
    <div class="row" style="margin-left: 350px;">
      
      <div class="col-sm-3">
        <div class="form-group">
          <label for="quant">Quantidade Plantio</label>
          <input type="text" id="quant" name="quant" placeholder="ex: 15.000,00"
          class="form-control">
           <strong>{{ $errors->first('quant') }}</strong> 
        </div>
      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="arroba">Arrobas (15Kg)</label>
                          <input type="number" id="arroba" name="arroba" autofocus placeholder="ex: 15"
                                 class="form-control">
                                   <strong>{{ $errors->first('arroba') }}</strong> 
                        </div>
                      </div>

      <div class="col-sm-3">
          <label for="totalQuilo">Kg Estimado</label>
        <input type="text" id="totalQuilo" name="totalQuilo" disabled="disabled"
        value="" class="form-control">
  </div>
    </div>

    <div class="row" style="margin-left: 350px;">
      <div class="col-sm-3">
        <div class="form-group">
          <label for="media"> Média Geral (Arroba)</label>
          <input type="text" id="media" name="media"  placeholder="ex: 160,50"
                 class="form-control">
                  <strong>{{ $errors->first('media') }}</strong> 
        </div>
      </div>
    
      <div class="col-sm-3">
        <div class="form-group">
          <label for="valorInsumo">Valor dos Insumos</label>
          <input type="text" id="valorInsumo" name="valorInsumo" placeholder="ex: 20.000,00"
                 class="form-control">
                   <strong>{{ $errors->first('valorInsumo') }}</strong> 
        </div>
      </div>
      <div class="col-sm-3">
          <label for="valorTotal">Valor Estimado</label>
        <input type="text" id="valorTotal" name="valorTotal" disabled="disabled"
        value="" class="form-control">
  </div>
      <div class="col-sm-3">
          <label for="subTotal">Valor Bruto Estimado</label>
        <input type="text" id="subTotal" name="subTotal" disabled="disabled"
        value="" class="form-control">
  </div>

  <div class="col-sm-3">
  <input type="hidden" id="valorTotalP" name="valorTotalP" disabled="disabled"
  value="" class="form-control">
</div>

    </div>

    <div style="margin-left: 560px;">
    <input type="submit" value="Enviar" class="btn btn-success">
    <input type="reset" value="Limpar" class="btn btn-warning">
    
</div>
    </form>
  </div>
  
  <br>


  <table class="table table-hover" id="tabela">
  <tr>
    <th > Arrobas (15Kg) </th>
    <th > Quantidade </th>
    <th > Quilos </th>
    <th > Média Geral</th>
    <th > Valor Insumos R$ </th>
    <th > Total R$ </th>
    <th > SubTotal R$ </th>
    <th > Ação</th>
  </tr>  
 @forelse($estimativas as $e)
  <tr id="tabelaResultado">
    <td> {{$e->arroba}} </td>  
    <td> {{number_format($e->quant, 2, ',', '.')}} </td>  
    <td> {{number_format($e->totalQuilo, 2, ',', '.')}} </td>  
    <td> {{number_format($e->media, 2, ',', '.')}} </td>  
    <td> {{number_format($e->valorInsumo, 2, ',', '.')}} </td>  
    <td> {{number_format($e->valorTotal, 2, ',', '.')}} </td>  
    <td> {{number_format($e->subTotal, 2, ',', '.')}} </td>  
    <td><form style="display: inline-block"
    method="post"
    action="{{route('estimativas.destroy', $e->id)}}"
    onsubmit="return confirm('Confirma Exclusão?')">
     {{method_field('delete')}}
     {{csrf_field()}}
    <button type="submit" title="Excluir"
            class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
</form>  
    </td>
   
</tr>

@empty
<trid="vazio"><tdcolspan=8>Não há estimativas feitas</td></tr>
@endforelse
</table>
{{ $estimativas->links() }} 

@endsection

@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#media').mask('#.###.##0,00', {reverse: true});
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#valorInsumo').mask('#.###.##0,00', {reverse: true});
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#quant').mask('#.###.##0,00', {reverse: true});
    });
  </script>

  <script>
  $(document).ready(function(){

    $("input").change(function(){
    
    quantV = $("input[name=quant]").val();
    quantP1 = quantV.replace(",", ".");
    
    //pegando os numeros dos campos inputs
    arroba = parseInt($("input[name=arroba]").val());
    quant = parseFloat(quantP1);
    
    //multiplica as arrobas por 15kg (uma arroba)
    multi = arroba * 15;

    //formula para cálculo do totalQuilo
    totalQuilo = (multi * quant);

    const formatado = totalQuilo.toLocaleString();
    
    //mostrar o resultado no input name=totalQuilo
    $("input[name=totalQuilo]").val(formatado);
    
    return false;
    });
    });
  </script>

  <script>
  $(document).ready(function(){

    $("input").change(function(){
    
    mediaV = $("input[name=media]").val();
    mediaP = mediaV.replace(",", ".");
    mediaP1 = mediaP.replace(".", "");

    media = parseFloat(mediaP1);
    totalQuilo = parseFloat($("input[name=totalQuilo]").val());
    

    //formula para cálculo do valorTotal
    valorTotal = (media * totalQuilo);
  
    const format = valorTotal.toLocaleString();

     const formatado = valorTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); //Mostra o R$

    //mostrar o resultado no input name=valorTotal
    $("input[name=valorTotal]").val(formatado);
    //mostrar o resultado no input name=valorTotalP
    $("input[name=valorTotalP]").val(format);
    
    return false;
    });
    });
  </script>
  
  <script>
  $(document).ready(function(){

    $("input").change(function(){

    valorTotalV = $("input[name=valorTotalP]").val();
    valorTotalP = valorTotalV.replace(",", ".");
    valorTotalP1 = valorTotalP.replace(".", "");

    valorInsumoV = $("input[name=valorInsumo]").val();
    valorInsumoP = valorInsumoV.replace(",", ".");
    valorInsumoP1 = valorInsumoP.replace(".", "");

    valorInsumo = parseFloat(valorInsumoP1);
    valorTotal = parseFloat(valorTotalP1);
    
    //formula para cálculo do valorTotal
    subTotal = (valorTotal - valorInsumo);
  
    //const formatado = subTotal.toLocaleString();
    const formatado = subTotal.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }); //Mostra o R$
    //mostrar o resultado no input name=subTotal
    $("input[name=subTotal]").val(formatado);
    
    return false;
    });
    });
  </script>



@endsection

