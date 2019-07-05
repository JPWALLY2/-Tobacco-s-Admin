@extends('adminlte::page')

@section('title', 'Marcas por Insumos')

@section('content_header')
    <h1>Marcas por Insumos
    {{-- <a href="{{route('vendas.index')}}" class="btn btn-primary pull-right" title="Ver Vendas"
       role="button"><i class="fas fa-eye"></i></a> --}}
    </h1>
@stop


@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Marcas', 'Nº de Insumos'],
@foreach ($insumos as $insumo) 
{!! "['$insumo->marcas', $insumo->num]," !!}
@endforeach          
        ]);

        var options = {
          title: 'Nº de Insumos por Marcas',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>

    <div id="piechart_3d" style=" height: 500px;"></div>

@endsection