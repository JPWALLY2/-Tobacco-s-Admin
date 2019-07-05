@extends('adminlte::page')

@section('title', 'Gráfico de Vendas por Anos')

@section('content_header')
    <h1>Gráfico de Vendas por Ano
    <a href="{{route('vendas.index')}}" class="btn btn-primary pull-right" title="Ver Vendas"
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