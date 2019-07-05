@section('title', 'Relatórios de Insumos')


<h1 style="color: green">Tabaco Admin</h1>
<title>Relatório de Insumos</title>
<h2>Relatório de Insumos</h2>
<link rel="stylesheet" type="text/css" href="vendor/adminlte/css/estilo.css">


<table border="1" widht=100% class="table1">
  <tr class="tabTop">
    <th>Nome</th>
    <th>Marca</th>
    <th>Tipo</th>
    <th>Quantidade</th>
  </tr>    

@foreach($insumo as $i)
<tr>
    <td>{{$i->nome }} </td>
    <td>{{$i->marcas->nome }} </td>
    <td>{{$i->tiposInsumos->nome}}</td>
    <td>{{$i->quant}}</td>   
  </tr>    
@endforeach  
</table>