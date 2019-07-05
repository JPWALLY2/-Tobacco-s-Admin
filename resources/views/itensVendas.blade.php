@extends('adminlte::page')

@section('title', 'Cadastro de Fumo Vendido')

@section('content_header')
        
<h2>Inclusão de Fumo Vendido</h2>


@endsection

@section('content')

   <div class="container-fluid">
      @section('content_header')
      <h1>Itens Comprados

          <a href="{{ route('vendas.index') }}"
          class="btn btn-primary pull-right " title="Voltar" role="button"><i class="fas fa-arrow-circle-left"></i></a>
      </h1>
  @endsection
  @if ($acao==1)
  {{-- <form method="POST" action="{{ route('instrutores.store') }}" enctype="multipart/form-data"> --}}
    <form method="POST" action="{{ route('createFumoVendido',$reg->id) }}" enctype="multipart/form-data">
@elseif ($acao==2)
  {{-- <form method="POST" action="{{route('instrutores.update', $reg->id)}}" enctype="multipart/form-data"> --}}
  {!! method_field('put') !!}
@endif 
   
    {{ csrf_field() }}
    
    <div class="row" style="margin-left: 400px;">
      <div class="col-sm-3">
        <div class="form-group">
          <label for="estoques_id">Posição da Folha</label>
          <select id="estoques_id" name="estoques_id" class="form-control" onchange="setQuilo()">
                @foreach($estoques as $e)
                <option value="{{$e->id}}" 
                    {{ ((isset($reg) and $reg->estoque == $e->id) or 
                     old('estoque') == $e->id) ? "selected" : "" }}>
                {{$e->posicaoFolha}}</option>
                @endforeach
          </select>  
        </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group">
          <label for="classes_id">Classe</label>
          <select id="classes_id" name="classes_id" class="form-control">
                @foreach($classes as $c)
                <option value="{{$c->id}}" 
                    {{ ((isset($reg) and $reg->classe == $c->id) or 
                     old('classe') == $c->id) ? "selected" : "" }}>
                {{$c->nome}}</option>
                @endforeach
          </select>  
        </div>
      </div>
    </div>
      <div class="row" style="margin-left: 400px;">
        <div class="col-sm-3">
          <div class="form-group">
            <label for="preco">Preço (1kg)</label>
            <input type="text" id="preco" name="preco"
                 value="{{$reg->preco or old('preco')}}"
                 class="form-control">
            <strong>{{ $errors->first('preco') }}</strong>                 

          </div>
        </div>
          <div class="col-sm-2">
            <div class="form-group">
                <label for="quilo">Quilo</label>
                <input type="text" id="quilo" name="quilo" onchange="valMax()" 
                 class="form-control">
            <strong>{{ $errors->first('quilo') }}</strong>                
            </div>
          </div>
          <div class="col-sm-2">
              <div class="form-group">
                  <input type="hidden" disabled="disabled" id="calc" name="calc"
                  value="{{$reg->total}}" class="form-control">
  
            </div>
          </div>
              @foreach($vendas as $v)
                <input type="hidden" id="vendas_id" name="vendas_id"
                value="{{$v->id}}" class="form-control">
              @endforeach
              
            <div class="col-sm-2">
                  <input type="hidden" id="total" name="total"
                  value="{{$reg->total or 0}}" class="form-control">
            </div>
            <div class="col-sm-2">
                  <input type="hidden" id="calc" name="calc"
                  value="{{$reg->total}}" class="form-control">
            </div>
            <div class="col-sm-2">
                  <input type="hidden" id="soma" name="soma"
                  value="{{$reg->total}}" class="form-control">
            </div>
          </div>

            <div style="margin-left: 540px;">
       <input type="submit" value="Enviar" class="btn btn-success">
       <input type="reset" value="Limpar" class="btn btn-warning">
    </div>

    </form>
   </div>

   <br>
  <a href="{{ route('vendas.index') }}"
    class="btn btn-primary pull-right " title="Voltar" role="button"><i class="fas fa-arrow-circle-left"></i></a>

    <br>
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
          <th>Posição da Folha</th>
          <th>Classe</th>
          <th>Quilo</th>
          <th>Preço (kg)</th>
          <th>Sub Total</th>
          <th>Ações</th>
        </tr>
        
        
        @forelse ($itensvendas as $iv)
          <tr id="tabelaResultado">
            <td> {{$iv->estoques->posicaoFolha}} </td>
            <td> {{$iv->classes->nome}} </td>
            <td> {{number_format($iv->quilo, 2, ',', '.')}} </td>
            <td> {{ number_format($iv->preco,2,',','.') }} </td>
            <td> {{number_format($iv->total, 2, ',', '.')}} </td>
            <td> 
                <form style="display: inline-block"
                      method="post"
                      action="{{route('destroyFumoVendido', $iv->id)}}"
                      onsubmit="return confirm('Confirma Exclusão?')">
                       {{method_field('delete')}}
                       {{csrf_field()}}
                      <button type="submit" title="Excluir"
                              class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                </form>
            </td>
            @if ($loop->iteration == $loop->count)
             <tr><td colspan=8>Total do fumo vendido R$: 
                               {{number_format($soma, 2, ',', '.')}}
                              </td></tr>                    
        @endif 
                
        @empty
          <tr id="vazio"><td colspan=8> Não há vendas cadastradas </td></tr>
        @endforelse
      
    </table> 
{{-- {{ $itensVendas->links() }} --}}
    @stop
 
@section('js')
  <script src="https://code.jquery.com/jquery-latest.min.js"></script>
  <script src="/js/jquery.mask.min.js"></script>
  
   
  <script>
    $(document).ready(function() {
      $('#preco').mask('#.###.##0,00', {reverse: true});
    });
  </script>    
  <script>
    $(document).ready(function() {
      $('#quilo').mask('#.###.##0,00', {reverse: true});
    });
  </script>    

  <script>
$(document).ready(function(){

$("input").change(function(){

precoV = $("input[name=preco]").val();
precoP = precoV.replace(".", "");
precoP1 = precoP.replace(",", ".");

quiloV = $("input[name=quilo]").val();
quiloP = quiloV.replace(".", "");
quiloP1 = quiloP.replace(",", ".");

quilo = parseFloat(quiloP1);
preco = parseFloat(precoP1);

//formula para cálculo do total
total = (preco * quilo);

//mostrar o resultado no input name=total
$("input[name=calc]").val(total);

return false;
});
});
  </script>


  <script>
$(document).ready(function(){

$("input").change(function(){

total = parseFloat($("input[name=total]").val());
calc = parseFloat($("input[name=calc]").val());


//formula para cálculo do total
soma = (calc + total);

//mostrar o resultado no input name=total
$("input[name=soma]").val(soma);

return false;
});
});
  </script>

<script>
  //pega o elemento estoques_id
    var inputEstoque = document.getElementById("estoques_id");
    
    //pega o quilo
    var inputQuilo = document.getElementById("quilo");
  
  // cria o vetor
    var quilosIntens = [];
  
  <?php
  // cria o indice 0
    $indiceVetor = 0;
  
    foreach ($estoques as $estoque) {
      // pega o quilo do vetor
      echo "\nquilosIntens[".$indiceVetor."] = ".$estoque->quilo.";";
      $indiceVetor++;
    }
  ?>
  
  // seta o quilo inicial
  setQuilo();
  
  function setQuilo() {
    var pos = inputEstoque.selectedIndex;
    mascaraInputQuilo(pos);
    // inputQuilo.value = quilosIntens[pos].toFixed(2);
  }
  
  function valMax() {

    //pega a posição do estoque selecionado
    var pos = inputEstoque.selectedIndex;

    //pega o quilo do input e joga numa string
    var strInput = inputQuilo.value;

    //formata o valor do input para numero calculavel (tudo em string)
    strInput = strInput.replace(".", "");
    strInput = strInput.replace(",", ".");

    //converte a string em numero
    var valNum = parseFloat(strInput);

    //verifica se o valor passou do limite
    if (valNum > quilosIntens[pos]) {
      //volta ao valor maximo
      mascaraInputQuilo(pos);
    }
  }

  function mascaraInputQuilo(pos) {
    
    //pega o valor do quilo correspondente a posicao (do vetor quilosIntens) passada no parametro
    //e converte em string
    var strValor = quilosIntens[pos].toFixed(2).toString();

    //pega o tamanho da string e coloca na varivel tam
    var tam = strValor.length;

    //cria a string nova (vazia)
    var strNova = "";

    //percorre a string que deve ser modificada ate a virgula (que por enquanto ainda e ponto)
    for (var i=0; i<tam-3; i++) {
      //adiciona na string nova o caractere correspondente
      strNova += strValor.charAt(i);
      //verifica a hora de colocar o ponto
      if (((tam-4) - i) % 3 == 0 && (tam-4) != i) {
        //coloca o ponto
        strNova += ".";
      }
    }

    //gambiarra leve para adicionar na string nova a virgula e o que vem depois dela
    strNova += "," + strValor.charAt(tam-2) + strValor.charAt(tam-1);

    //coloca a string nova no input do quilo
    inputQuilo.value = strNova;
  }
  
   </script>
 
  @endsection
