@extends('adminlte::page')

@section('title', 'Historico de Compras')

@section('content')

    @section('content_header')
    <h1>Histórico de Compras</h1>
    @endsection
    
    <form action="{{route('pesquisaHistoricoCompras')}}" method="POST" class="form form-inline pull-right">
        {{ csrf_field() }}
        <input type="date" name="date" class="form-control"">
        <input type="text" name="total" id="total" class="form-control" placeholder="Total">
        <select id="empresas_id" name="empresas_id" class="form-control">
            <option value="">--- Selecione a empresa ---</option>
            @foreach($empresas as $emp)
              <option value="{{$emp->id}}" 
                      {{ ((isset($reg) and $reg->empresas_id == $emp->id) or 
                         old('empresas_id') == $emp->id) ? "selected" : "" }}>
                      {{$emp->nome}}  </option>
            @endforeach
          </select>  
        <button type="submit" class="btn btn-primary" title="Pesquisar"><i class="fas fa-search"></i></button>
        <a href="{{ route('historicoCompras') }}"  class="btn btn-warning" role="button" title="Todos"><i class="fas fa-list"></i></a>
    </form>


  <table class="table table-hover" id="tabela">
    <tr>
      <th>Total R$</th>
      <th>Comprado da Empresa</th>
      <th>Data</th>
    </tr>
    @forelse ($compras as $c)
    <tr id="tabelaResultado">
        <td> {{number_format($c->total, 2, ',', '.')}} </td>
        <td> {{$c->empresas->nome}} </td>        
        <td> {{date_format($c->created_at, 'd/m/Y')}} </td>
              
    @empty
      <tr id="vazio"><td colspan=8> Não há resultados de pesquisa ou compras feitas</td></tr>
    @endforelse

</table>  
{{ $compras->links() }}

  
@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>
<script>
  $(document).ready(function() {
    $('#total').mask('#.###.##0,00', {reverse: true});
  });
</script> 
@endsection
@stop