@extends('adminlte::page')

@section('title', 'Cadastro de Instrutores')

@section('content')

<div class="container-fluid">
    @section('content_header')
    <h1>Cadastro de Visitas</h1>
@endsection

    @if ($acao==1)
      <form method="POST" action="{{ route('visitas.store') }}" enctype="multipart/form-data">
    @elseif ($acao==2)
      <form method="POST" action="{{route('visitas.update', $reg->id)}}" enctype="multipart/form-data">
      {!! method_field('put') !!}
    @endif          
    {{ csrf_field() }}

    <div class="row" style="margin-left: 250px;">
      <div class="col-sm-4">
        <div class="form-group">
          <label for="motivo">Motivo</label>
          <input type="text" id="motivo" name="motivo" autofocus
                 value="{{$reg->motivo or old('motivo')}}"
                 class="form-control">
                 <strong>{{ $errors->first('motivo') }}</strong>                 
        </div>
      </div>

      <div class="col-sm-4">
        <div class="form-group">
          <label for="instrutors_id">Instrutor</label>
          <select id="instrutors_id" name="instrutors_id" class="form-control">
            @foreach($instrutores as $ins)
              <option value="{{$ins->id}}" 
                      {{ ((isset($reg) and $reg->instrutors_id == $ins->id) or 
                         old('instrutors_id') == $ins->id) ? "selected" : "" }}>
                      {{$ins->nome}}</option>
            @endforeach
          </select>  
        </div>
      </div>
    </div>              

    <div class="row" style="margin-left: 250px;">
        <div class="col-sm-4">
          <div class="form-group">
            <label for="observacao">Observação</label>
            <textarea inputmode="latin-name" name="observacao" id="observacao" cols="45" rows="5" 
            value="{{$reg->observacao or old('observacao')}}"></textarea> 
            <strong>{{ $errors->first('observacao') }}</strong>                 
          </div>
        </div>
     </div>
     
     <div style="margin-left: 655px;">
        <input type="submit" value="Enviar" class="btn btn-success">
        <input type="reset" value="Limpar" class="btn btn-warning">
      </div>
      
    </form>
  </div>
  
  <br>

<table class="table table-hover" id="tabela">
    <tr>
        <th>Instrutor</th>
      <th>Motivo</th>
      <th>Observação</th>
      <th>Data</th>
      <th>Ações</th>
    </tr>
      
    @forelse ($visitas as $v)
      <tr id="tabelaResultado">
          <td> {{$v->instrutors->nome}} </td>
        <td> {{$v->motivo}} </td>
        <td> {{$v->observacao}} </td>
        <td> {{date_format($v->created_at, 'd/m/Y')}} </td>
        <td> 
            <a href="{{route('visitas.edit', $v->id)}}" 
                class="btn btn-warning btn-sm" title="Alterar"
                role="button"><i class="fa fa-edit"></i></a>
            <form style="display: inline-block"
                  method="post"
                  action="{{route('visitas.destroy', $v->id)}}"
                  onsubmit="return confirm('Confirma Exclusão?')">
                   {{method_field('delete')}}
                   {{csrf_field()}}
                  <button type="submit" title="Excluir"
                          class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
        </td>
            
    @empty
      <tr id="vazio"><td colspan=8> Não há visitas cadastradas </td></tr>
    @endforelse

</table>  
{{ $visitas->links() }}

@stop