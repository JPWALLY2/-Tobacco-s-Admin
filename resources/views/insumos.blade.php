@extends('adminlte::page')

@section('title', 'Lista de Insumos')

@section('content')


<div class="container-fluid">
@section('content_header')
  <h1>Cadastro de Insumos</h1>
@endsection

  @if ($acao==1)
    <form method="POST" action="{{ route('insumos.store') }}" enctype="multipart/form-data">
  @else ($acao==2)
    <form method="POST" action="{{ route('insumos.update', $reg->id)}}" enctype="multipart/form-data">
    {!! method_field('put') !!}
  @endif          
  {{ csrf_field() }}

  
  <div class="row" style="margin-left: 250px;">
    <div class="col-sm-4">
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome"
               value="{{$reg->nome or old('nome')}}"
               class="form-control">
               <strong>{{ $errors->first('nome') }}</strong>
      </div>
    </div>
      <div class="col-sm-3">
        <div class="form-group">
          <label for="marcas_id">Marca</label>
          <select id="marcas_id" name="marcas_id" class="form-control">      
            @foreach($marcas as $m)
            <option value="{{$m->id}}" 
                {{ ((isset($reg) and $reg->marcas_id == $m->id) or 
                         old('marcas_id') == $m->id) ? "selected" : "" }}>
                      {{$m->nome}}</option>
                      @endforeach
                    </select>  
                  </div>
      </div>
    </div>
    <div class="row" style="margin-left: 250px;">
        <div class="col-sm-4">
          <div class="form-group">
            <label for="tiposInsumos_id">Tipo de Insumo</label>
            <select id="tiposInsumos_id" name="tiposInsumos_id" class="form-control">
              @foreach($tin as $TI)
              <option value="{{$TI->id}}" 
                  {{ ((isset($reg) and $reg->tiposInsumos_id == $TI->id) or 
                           old('tiposInsumos_id') == $TI->id) ? "selected" : "" }}>
                        {{$TI->nome}}</option>
                        @endforeach
                      </select>  
                    </div>
                  </div>
        <div class="col-sm-2">
          <div class="form-group">
            <label for="quant">Quantidade</label>
            <input type="number" min="0" id="quant" name="quant" 
   value="{{$reg->quant or old('quant')}}"
   class="form-control">
        </div>
        </div>
      </div>
  
  

  <div style="margin-left: 590px;">
  <input type="submit" value="Enviar" class="btn btn-success">
  <input type="reset" value="Limpar" class="btn btn-warning">
</div>

  </form>
</div>

<br>
@if (session('status'))
<div class="alert-danger" style="text-align: center">
      {{ session('status') }}
    </div>  
    <script>
        setTimeout(function(){ 
            var msg = document.getElementsByClassName("alert-danger");
            while(msg.length > 0){
                msg[0].parentNode.removeChild(msg[0]);
            }
        }, 3000);
    </script>
@endif

<table class="table table-hover" id="tabela">
    <tr>
      <th>Nome</th>
      <th>Marca</th>
      <th>Tipo</th>
      <th>Quantidade</th>
      <th>Preço</th>
      <th>Data</th>
      <th>Ações</th>
    </tr>
    
    @forelse ($insumos as $i)
      <tr id="tabelaResultado">
        <td> {{$i->nome}} </td>
        <td> {{$i->marcas->nome}} </td>
        <td> {{$i->tiposInsumos->nome}} </td>      
        <td> {{$i->quant}} </td>
        <td> {{number_format($i->preco, 2, ',', '.')}} </td>
        <td> {{date_format($i->created_at, 'd/m/Y')}} </td>
        <td> 
            <a href="{{route('insumos.edit', $i->id)}}" 
                class="btn btn-warning btn-sm" title="Alterar"
                role="button"><i class="fa fa-edit"></i></a>
            <form style="display: inline-block"
                  method="post"
                  action="{{route('insumos.destroy', $i->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
            
    @empty
      <tr id="vazio"><td colspan=8> Não há insumos cadastrados </td></tr>
    @endforelse

</table>  
{{ $insumos->links() }}
@endsection
