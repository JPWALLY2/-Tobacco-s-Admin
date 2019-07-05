@extends('adminlte::page')

@section('title', 'Gerar Relatório')

@section('content')

<div class="container-fluid">
  @section('content_header')
  <h2>Gerar Relatório de Insumos</h2>
@endsection        
<form method="post" action="{{ route('relInsumos') }}">
  {{ csrf_field() }}

  <div class="row" style="margin-left: 300px;">
   
    <div class="col-sm-4">
      <div class="form-group">
        <label for="tiposInsumos_id">Tipo</label>
        <select id="tiposInsumos_id" name="tiposInsumos_id" class="form-control">
                <option value="">--- Selecione o tipo ---</option>
                @foreach($tiposInsumos as $ti)
                  <option value="{{$ti->id}}" 
                          {{ ((isset($reg) and $reg->tiposInsumos_id == $ti->id) or 
                             old('tiposInsumos_id') == $ti->id) ? "selected" : "" }}>
                          {{$ti->nome}}</option>
                @endforeach
              </select>  
        <strong>{{ session('status1') }}</strong>  
        <strong>{{ $errors->first('tiposInsumos_id') }}</strong>                 


      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label for="marcas_id">Marca</label>
        <select id="marcas_id" name="marcas_id" class="form-control">
                <option value="">--- Selecione a marca ---</option>
                @foreach($marcas as $m)
                  <option value="{{$m->id}}" 
                          {{ ((isset($reg) and $reg->marcas_id == $m->id) or 
                             old('marcas_id') == $m->id) ? "selected" : "" }}>
                          {{$m->nome}}</option>
                @endforeach
              </select>  
        <strong>{{ session('status') }}</strong>   
        <strong>{{ $errors->first('marcas_id') }}</strong>                 


      </div>
    </div>
  </div>
  
  <div style="margin-left: 780px;">
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
