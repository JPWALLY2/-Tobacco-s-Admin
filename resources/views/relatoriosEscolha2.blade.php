@extends('adminlte::page')

@section('title', 'Gerar Relatório')

@section('content')

<div class="container-fluid">
  @section('content_header')
  <h2>Gerar Relatório de Insumos Comprados</h2>
@endsection        
<form method="post" action="{{ route('relItensComprados') }}">
  {{ csrf_field() }}

  <div class="row" style="margin-left: 350px;">
        <div class="col-sm-3">
    <div class="form-group">
        <label for="dataIni">Data Inicial</label>
        <input type="date" name="dataIni" id="dataIni" class="form-control">
        <strong>{{ session('status') }}</strong>  
        <strong>{{ $errors->first('dataIni') }}</strong>                 


        </div>
    </div>
        <div class="col-sm-3">
    <div class="form-group">
        <label for="dataFin">Data Final</label>
        <input type="date" name="dataFin" id="dataFin" class="form-control">
        <strong>{{ session('status') }}</strong>     
        <strong>{{ $errors->first('dataFin') }}</strong>                 


        </div>
    </div>
  </div>
  <div class="row" style="margin-left: 350px;">

    <div class="col-sm-4">
      <div class="form-group">
        <label for="empresa">Empresa</label>
        <select id="empresas_id" name="empresas_id" class="form-control">
                <option value="">--- Selecione a empresa ---</option>
                @foreach($empresas as $e)
                  <option value="{{$e->id}}" 
                          {{ ((isset($reg) and $reg->empresas_id == $e->id) or 
                             old('empresas_id') == $e->id) ? "selected" : "" }}>
                          {{$e->nome}}</option>
                @endforeach
              </select>  
        <strong>{{ session('status') }}</strong>     
        <strong>{{ $errors->first('empresas_id') }}</strong>                 

      </div>
    </div>
  </div>
  
  <div style="margin-left: 670px;">
    <button type="submit" title="Gerar Relatório"
    class="btn btn-success btn-sm"><i class="fas fa-envelope-open-text"></i></button>
  </div>
</form>

</div>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="/js/jquery.mask.min.js"></script>
@endsection
