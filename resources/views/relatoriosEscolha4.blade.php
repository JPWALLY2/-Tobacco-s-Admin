@extends('adminlte::page')

@section('title', 'Gerar Relatório')

@section('content')

<div class="container-fluid">
  @section('content_header')
  <h2>Gerar Relatório de Anos</h2>
@endsection        
<form method="post" action="{{ route('relAnos') }}">
  {{ csrf_field() }}

  <div class="row" style="margin-left: 450px;">
    <div class="col-sm-3">
    <div class="form-group">
        <label for="data">Data</label>
        <input type="text" name="data" id="data" class="form-control" autofocus>
        <strong>{{ $errors->first('data') }}</strong>                
        <strong>{{ session('status') }}</strong>                
        </div>
    </div>
  </div>
       
  <div style="margin-left: 660px;">
    <button type="submit" title="Gerar Relatório"
    class="btn btn-success btn-sm"><i class="fas fa-envelope-open-text"></i></button>
  </div>
</form>

</div>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="/js/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data').mask('0000', {reverse: true});
    });
</script> 

@endsection