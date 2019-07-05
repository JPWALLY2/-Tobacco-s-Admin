@section('title', 'Relatórios de Anos')


<h1 style="color: green">Tabaco Admin</h1>
<title>Relatório de Anos</title>
<h3 style="text-align: center">Relatório de Anos</h3>
<link rel="stylesheet" type="text/css" href="vendor/adminlte/css/estilo.css">

@if ($acao==1)
<h2>Fumo vendido no ano</h2>

<table border="1" widht=100% class="table1">
  <tr class="tabTop">
    <th>Ano</th>
    <th>Nº de Vendas</th>
    <th>SubTotal R$ (Valor Bruto):</th>
    <th>Total de Quilos </th>
    <th>Média (1kg)</th>
    <th>Média por Arroba (15kg)</th>
  </tr>    
  
  @foreach($venda as $v)
  <tr>
    //passar o ano do vend
    <td> {{ ($v->anos)}} </td>    
    <td> {{ ($vendaID)}} </td>    
    <td>{{number_format($vendaTotal, 2, ',', '.')}}</td>
    <td>{{number_format($vendaTotalQuilo, 2, ',', '.')}}</td>
    <td>{{number_format($vendaMedia, 2, ',', '.')}}</td>
    <td>{{number_format($vendaMediaArroba, 2, ',', '.')}}</td>
  </tr>    
  @endforeach  
</table>

<br>

@elseif ($acao==2)

<h2>Insumos comprados no ano</h2>

<table border="1" widht=100% class="table1">
  <tr class="tabTop">
    <th>Ano</th>
    <th>Nº de Compras</th>
    <th>SubTotal R$:</th>
  </tr>    
  
  @foreach($compra as $c)
  <tr>
    //passar o ano do vend
    <td> {{ ($c->anos)}} </td>    
    <td> {{ ($compraID)}} </td>    
    <td>{{number_format($compraTotal, 2, ',', '.')}}</td>
  </tr> 
  @endforeach  
</table>

<br>

@else ($acao == 3)

<h2>Fumo vendido no ano</h2>

<table border="1" widht=100% class="table1">
  <tr class="tabTop">
    <th>Ano</th>
    <th>Nº de Vendas</th>
    <th>SubTotal R$ (Valor Bruto):</th>
    <th>Total de Quilos </th>
    <th>Média (1kg)</th>
    <th>Média por Arroba (15kg)</th>
  </tr>    
  
  @foreach($venda as $v)
  <tr>
    //passar o ano do vend
    <td> {{ ($v->anos)}} </td>    
    <td> {{ ($vendaID)}} </td>    
    <td>{{number_format($vendaTotal, 2, ',', '.')}}</td>
    <td>{{number_format($vendaTotalQuilo, 2, ',', '.')}}</td>
    <td>{{number_format($vendaMedia, 2, ',', '.')}}</td>
    <td>{{number_format($vendaMediaArroba, 2, ',', '.')}}</td>
    
  </tr>    
  @endforeach  
</table>

<br>

<h2>Insumos comprados no ano</h2>

<table border="1" widht=100% class="table1">
  <tr class="tabTop">
    <th>Ano</th>
    <th>Nº de Compras</th>
    <th>SubTotal R$:</th>
  </tr>    
  
  @foreach($compra as $c)
  <tr>
    //passar o ano do vend
    <td> {{ ($c->anos)}} </td>    
    <td> {{ ($compraID)}} </td>    
    <td>{{number_format($compraTotal, 2, ',', '.')}}</td>
  </tr> 
  @endforeach  
</table>

<br>

<table border="1" widht=100% class="table1">
  <tr class="tabTop">
    <th>Lucro (Valor Líquido) R$:</th>
  </tr>    

@foreach($compra as $c)
<tr>
  <td>{{number_format($valorLiquido, 2, ',', '.')}}</td>    

  </tr> 
    
@endforeach  
</table>

@endif