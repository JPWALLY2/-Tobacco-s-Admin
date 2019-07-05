@extends('adminlte::page')

@section('title', 'Cadastro de Vendas')

@section('content')

<div class="container-fluid">
    @section('content_header')
    <h1>Cadastro de Vendas</h1>
    @endsection

    @if ($acao==1)
      <form method="POST" action="{{ route('vendas.store') }}" enctype="multipart/form-data">
    @else ($acao==2)
      <form method="POST" action="{{route('vendas.update', $reg->id)}}" enctype="multipart/form-data">
      {!! method_field('put') !!}
    @endif          
    {{ csrf_field() }}

    
    <div class="row" style="margin-left: 415px;">
        <div class="col-sm-4">
          <div class="form-group">
             
            <label for="empresas_id">Empresa</label>
            <select id="empresas_id" name="empresas_id" class="form-control">
              @foreach($empresas as $emp)
                <option value="{{$emp->id}}" 
                        {{ ((isset($reg) and $reg->empresas_id == $emp->id) or 
                           old('empresas_id') == $emp->id) ? "selected" : "" }}>
                        {{$emp->nome}}</option>
              @endforeach
            </select>  
          </div>
        </div>
      </div>
     
       
      
        <div style="margin-left: 580px;">
            <input type="submit" value="Enviar" class="btn btn-success">
        </div>
    </form>
  </div>

  <br>

<table class="table table-hover" id="tabela">
    <tr>
      <th>Total R$</th>
      <th>Total de Quilos</th>
      <th>Vendido para a Empresa</th>
      <th>Data</th>
      <th>Ações</th>
    </tr>
    @forelse ($vendas as $v)
    <tr id="tabelaResultado">
        <td> {{number_format($v->total, 2, ',', '.')}} </td>
        <td> {{number_format($v->totalQuilo, 2, ',', '.')}} </td>
        <td> {{$v->empresas->nome}} </td>  
        <td> {{date_format($v->created_at, 'd/m/Y')}} </td>
        
        <td> 
            <a href="{{route('indexFumoVendido', $v->id)}}" 
                class="btn btn-success btn-sm" title="Adicionar Fumo Vendido"
                role="button"><i class="fas fa-plus-circle"></i></a>
            <form style="display: inline-block"
                  method="post"
                  action="{{route('vendas.destroy', $v->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
        @if ($loop->iteration == $loop->count)
             <tr><td colspan=8>Total das Vendas Feitas R$: 
                               {{number_format($soma, 2, ',', '.')}}
                              ---- Nº de Vendas: {{$numVendas}}                              
                              </td></tr>
                            
        @endif        
    @empty
      <tr id="vazio"><td colspan=8> Não há vendas cadastrados ou 
                         para o filtro informado </td></tr>
    @endforelse

</table>  
{{ $vendas->links() }}

@stop