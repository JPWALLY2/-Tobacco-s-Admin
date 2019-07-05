@extends('adminlte::page')

@section('title', 'Inicio')



@section('content_header')

    <h1>Dashboard</h1>
@stop

@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Ano', 'Nº de Vendas'],
@foreach ($vendas as $venda) 
{!! "['$venda->anos', $venda->num]," !!}
@endforeach          
        ]);

        var options = {
          title: 'Nº de Vendas por Ano',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

    <div id="piechart_3d" style=" height: 500px;"></div>

@endsection