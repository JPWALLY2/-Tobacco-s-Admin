@section('title', 'Relatórios de Fumo Vendido')


<h1 style="color: green">Tabaco Admin</h1>
<title>Relatório de Fumo Vendido</title>
<h2>Relatório de Fumo Vendido</h2>
<link rel="stylesheet" type="text/css" href="vendor/adminlte/css/estilo.css">


<table border="1" widht=100% class="table1">
  <tr class="tabTop">
    <th>Empresa</th>
    <th>Classe</th>
    <th>Quilo</th>
    <th>Preço R$:</th>
    <th>Total R$:</th>
    <th>Data</th>
  </tr>    

@foreach($itensVendas as $iv)
<tr>
    <td>{{$iv->vendas->empresas->nome }} </td>
    <td>{{$iv->classes->nome}}</td>
    <td>{{number_format($iv->quilo, 2, ',', '.')}}</td>
    <td>{{number_format($iv->preco, 2, ',', '.')}}</td>
    <td>{{number_format($iv->total, 2, ',', '.')}}</td>
    <td> {{date_format($iv->created_at, 'd/m/Y')}} </td>    
  </tr>    
@endforeach  
</table>