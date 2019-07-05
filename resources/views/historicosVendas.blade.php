@extends('adminlte::page')

@section('title', 'Historico de Vendas')

@section('content')

    @section('content_header')
    <h1>Histórico de Vendas</h1>
    @endsection
    
    <form action="{{route('pesquisaHistoricoVendas')}}" method="POST" class="form form-inline pull-right">
        {{ csrf_field() }}
        <input type="date" name="date" class="form-control">
        <input type="text" name="total" id="total" class="form-control" placeholder="Total">
        <input type="text" name="totalQuilo" id="totalQuilo" class="form-control" placeholder="Total de Quilos">
        <select id="empresas_id" name="empresas_id" class="form-control">
            <option value=""> --- Selecione a empresa ---</option>
            @foreach($empresas as $emp)
              <option value="{{$emp->id}}" 
                      {{ ((isset($reg) and $reg->empresas_id == $emp->id) or 
                         old('empresas_id') == $emp->id) ? "selected" : "" }}>
                      {{$emp->nome}}  </option>
            @endforeach
          </select>  
        <button type="submit" class="btn btn-primary" title="Pesquisar"><i class="fas fa-search"></i></button>
        <a href="{{ route('historicoVendas') }}"  class="btn btn-warning" role="button" title="Todos"><i class="fas fa-list"></i></a>
    </form>


  <table class="table table-hover" id="tabela">
    <tr>
      <th>Totalde Quilos</th>
      <th>Total R$</th>
      <th>Vendido para a Empresa</th>
      <th>Data</th>
    </tr>
    @forelse ($vendas as $v)
    <tr id="tabelaResultado">
        <td> {{number_format($v->totalQuilo, 2, ',', '.')}} </td>
        <td> {{number_format($v->total, 2, ',', '.')}} </td>
        <td> {{$v->empresas->nome}} </td>        
        <td> {{date_format($v->created_at, 'd/m/Y')}} </td>
              
    @empty
      <tr id="vazio"><td colspan=8> Não há resultados de pesquisa ou vendas feitas</td></tr>
    @endforelse

</table>  
{{ $vendas->links() }}

  
@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>
<script>
  $(document).ready(function() {
    $('#total').mask('#.###.##0,00', {reverse: true});
  });
</script> 
<script>
  $(document).ready(function() {
    $('#totalQuilo').mask('#.###.##0,00', {reverse: true});
  });
</script> 
@endsection
@stop