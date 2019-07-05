@extends('adminlte::page')

@section('title', 'Gráfico de Compras por Empresas')

@section('content_header')
    <h1>Gráfico de Compras por Empresas
    <a href="{{route('compras.index')}}" class="btn btn-primary pull-right" title="Ver Vendas"
       role="button"><i class="fas fa-eye"></i></a>
    </h1>
@stop


@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Empresas', 'Nº de Compras'],
@foreach ($compras as $compra) 
{!! "['$compra->empresas', $compra->num]," !!}
@endforeach  

        ]);

        var options = {
          title: 'Nº de Compras por Empresa',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

    <div id="piechart_3d" style=" height: 500px;"></div>

  @endsection
