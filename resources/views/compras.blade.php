@extends('adminlte::page')

@section('title', 'Listagem de Compras')

@section('content')

<div class="container-fluid">
    @section('content_header')
    <h1>Cadastro de Compras</h1>
    @endsection

    @if ($acao==1)
      <form method="POST" action="{{ route('compras.store') }}" enctype="multipart/form-data">
    @else ($acao==2)
      <form method="POST" action="{{route('compras.update', $reg->id)}}" enctype="multipart/form-data">
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
      <th>Comprado da Empresa</th>
      <th>Data</th>
      <th>Ações</th>
    </tr>
    @forelse ($compras as $c)
    <tr id="tabelaResultado">
        <td> {{number_format($c->total, 2, ',', '.')}} </td>
        <td> {{$c->empresas->nome}} </td>        
        <td> {{date_format($c->created_at, 'd/m/Y')}} </td>
        
        <td> 
                     <a href="{{route('indexItensComprados', $c->id)}}" 
                class="btn btn-success btn-sm" title="Adicionar Insumos"
                role="button"><i class="fas fa-plus-circle"></i></a>
            <form style="display: inline-block"
                  method="post"
                  action="{{route('compras.destroy', $c->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
        @if ($loop->iteration == $loop->count)
             <tr><td colspan=8>Total das Compras Feitas R$: 
                               {{number_format($soma, 2, ',', '.')}}
                              ---- Nº de Compras: {{$numCompras}}                              
                              </td></tr>                    
        @endif        
    @empty
      <tr id="vazio"><td colspan=8> Não há compras cadastrados </td></tr>
    @endforelse

</table>  
{{ $compras->links() }}

@stop