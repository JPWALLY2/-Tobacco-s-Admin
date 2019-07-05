@section('title', 'Relatórios de Fumo Vendido')


<h1 style="color: green">Tabaco Admin</h1>
<title>Relatório de Itens Comprados</title>
<h2>Relatório de Itens Comprados</h2>
<link rel="stylesheet" type="text/css" href="vendor/adminlte/css/estilo.css">


<table border="1" widht=100% class="table1">
  <tr class="tabTop">
    <th>Empresa</th>
    <th>Insumo</th>
    <th>Quantidade</th>
    <th>Preço R$:</th>
    <th>Total R$:</th>
    <th>Data</th>
  </tr>    

@foreach($itensCompras as $ic)
<tr>
    <td>{{$ic->compras->empresas->nome }} </td>
    <td>{{$ic->insumos->nome}}</td>
    <td>{{$ic->quant}}</td>
    <td>{{number_format($ic->preco, 2, ',', '.')}}</td>
    <td>{{number_format($ic->total, 2, ',', '.')}}</td>
    <td>{{date_format($ic->created_at, 'd/m/Y')}} </td>    
  </tr>    
@endforeach  
</table>