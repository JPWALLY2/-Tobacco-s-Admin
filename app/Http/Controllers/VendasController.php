<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\Painel\Itens_VendaFormRequest;
use App\Http\Requests\RelEscolha_SafrasFormRequest;
use App\Http\Requests\RelEscolha_ItensVendasFormRequest;

use App\Venda;
use App\Compra;
use App\Empresa;
use App\Classe;
use App\Itens_Venda;
use App\Estoque;
use Illuminate\Support\Facades\DB;


class VendasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Venda::orderByDesc('created_at')->paginate(5);

        $soma = Venda::sum('total');   // obtém a soma do campo total

        $numVendas = Venda::count('id');  // obtém o número de registros

        $empresas = Empresa::orderBy('nome')->get();

        $estoques = Estoque::orderBy('posicaoFolha')->get();

        return view('vendas', 
        [
            'vendas'=>$dados, 
            'soma'=>$soma, 
            'numVendas'=>$numVendas,
            'empresas'=>$empresas,
            'estoques'=>$estoques,
            'acao'=>1, 
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();

        $inc = Venda::create($dados);

        if ($inc) {
            return redirect()->route('vendas.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reg = Venda::find($id);

        $empresas = Empresa::orderBy('nome')->get();

        $dados = Venda::paginate(7);

        return view('vendas', 
        [
            'reg' => $reg, 
            'empresas' => $empresas, 
            'vendas' => $dados, 
            'acao' => 2
            ]
        );
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dados = $request->all();

        $reg = Compra::find($id);
        
        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('vendas.index'); 
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vend = Venda::find($id);
        if ($vend->delete()) {
            return redirect()->route('vendas.index');
        }
    }
    
    public function index2($id)
    {
        $itensVendas = Itens_Venda::where('vendas_id', $id)->paginate(5); 

        $classes = Classe::orderBy('nome')->get();

        $estoques = Estoque::orderBy('posicaoFolha')->get();

        $vendas = Venda::orderBy('id')->get();

        $reg = Venda::find($id);

        $soma = Itens_Venda::where('vendas_id', $id)->sum('total');

        return view('itensVendas', 
        [
             'reg' => $reg,  
             'classes' => $classes,
             'estoques' => $estoques,
             'vendas' => $vendas,
             'itensvendas' => $itensVendas,
             'soma' => $soma,
              'acao' => 1
        ]
            );
    }

    public function create2(Itens_VendaFormRequest $request, $id)
    {
        //pega os dados de cada input e direciona para sua tabela específica
        $itensVendas['quilo'] = $request->get('quilo');
        $itensVendas['preco'] = $request->get('preco');
        $itensVendas['total'] = $request->get('calc');
        $itensVendas['classes_id'] = $request->get('classes_id');
        $itensVendas['estoques_id'] = $request->get('estoques_id');
        $itensVendas['vendas_id'] = $id;
        
        //pega a soma para inserir na tabela compras
        $vendas['total'] = $request->get('soma');

         //pega o id da classe informado
         $dadosU = $request->classes_id;
        
         //verifica se o id da classe existe
         $idI = Itens_Venda::where('vendas_id', $id)->where('classes_id', $dadosU)->get();
 
         if($idI->count()>0){
             return redirect()->route('indexFumoVendido', $id)
             ->with('status', 'A classe já existe nesta venda!');
         }


        //cadastra na tabela itens_compras os itens
        Itens_Venda::create($itensVendas);

           //pega id da venda
           $reg = Venda::find($id);


        //pega o id do estoque informado no form
        $regE = Estoque::find($request->estoques_id);
        
        $novo1 = str_replace('.', '', $request->quilo); 
        $novo2 = str_replace(',', '.', $novo1); 

        //subtrai o estoque
        $regE->quilo -= $novo2;

           $totalQ = $reg->totalQuilo;

           $novo1 = str_replace('.', '', $request->quilo); 
           $novo2 = str_replace(',', '.', $novo1); 
           
           $totalQ = $reg->totalQuilo += $novo2; 

           //atualiza a informação do registro
           $alt = $reg->update($vendas);
           $altE = $regE->update();

           //se cadastrou e alterou certo
        if ($itensVendas && $alt && $altE) {
            return redirect()->route('indexFumoVendido', $id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy2($id)
    {
        //pega o id do iten
        $fumoV = Itens_Venda::find($id);

        //pega o id da venda do iten
        $id2 = $fumoV->vendas_id;

        //pega o id do estoque do iten
        $id3 = $fumoV->estoques_id;

         //pega o total do iten
         $totalIVenda = $fumoV->total;

         //pega o quilo do iten
         $quiloIVenda = $fumoV->quilo;

         //pega o quilo2 do iten
         $quiloIVenda = $fumoV->quilo;
         
        //pega o estoque do iten
        $estoque = Estoque::find($id3);

        //soma o quilo 
        $estoque->quilo += $quiloIVenda;

        //pega a venda do iten
        $venda = Venda::find($id2);
        
        //subtrai o total 
        $venda->total -= $totalIVenda;

        //subtrai o totalQuilo 
        $venda->totalQuilo -= $quiloIVenda;

        //altera o total da venda
        $altV = $venda->update();

        //altera o quilo do estoque
        $altE = $estoque->update();

        
        if ($altE && $altV && $fumoV->delete()) {
            return redirect()->route('indexFumoVendido', $id2);
        }
    }

    public function historico(Venda $venda){

        $vendas = Venda::orderByDesc('created_at')->paginate(5);

        $empresas = Empresa::orderBy('nome')->get();

        return view('historicosVendas',
        [
            'vendas'=>$vendas,
            'empresas'=>$empresas
              ]
            );
    }

    public function pesquisa(Request $request, Venda $venda){

        $dataForm = $request->all();

        $vendas = $venda->search($dataForm);

        $empresas = Empresa::orderBy('nome')->get();

        return view('historicosVendas',
        [
            'vendas'=>$vendas,
            'empresas'=>$empresas
              ]
            );
    }

    public function grafemp() {
        $vendas = 
    DB::table('vendas')
    ->join('empresas', 'vendas.empresas_id', '=', 'empresas.id')
    ->select('empresas.nome as empresas', 
             DB::raw('count(*) as num'))
    ->groupBy('empresas.nome')
    ->get();         

        return view('vendas_graf', 
                    ['vendas' => $vendas]);
    }

    public function grafanos() {
      
        $vendas = DB::table('vendas')
        ->select(DB::raw('count(*) as num, year(created_at) as anos'))
        ->groupBy(DB::raw('year(created_at)'))
        ->get();

        return view('vendasanos_graf',
        ['vendas' => $vendas]);
         }

  public function relEscolha(){

    $empresas = Empresa::orderBy('nome')->get();

    return view('relatoriosEscolha',
    [
        'empresas'=>$empresas
          ]
        );
    
}

public function relItensVendas(RelEscolha_ItensVendasFormRequest $request, Venda $vendas) {
        
    //pega as empresas_id do form
    $dataForm = $request->all();
    
    //pega a data inicial e a data final
    $dataI = $request->dataIni;
    $dataF = $request->dataFin;

    //joga a empresas_id para a função de procura na model das vendas
    $venda = $vendas->search($dataForm);

     //pega o itens venda das datas entre a data inicial e data final atraves do whereBetween
     $itensVendas = Itens_Venda::orderByDesc('created_at')->
     whereBetween('created_at',[$dataI, $dataF])->get();

    //pega o id da venda q tenha o id da empresa
    $vend = Venda::where('empresas_id', '=', $request->empresas_id)->pluck('id');

    $empresas = Empresa::orderBy('nome')->get();
    $classes = Classe::orderBy('nome')->get();


    //se as datas iniciais e finais estiver preenchido e a venda tiver pelomenos um registro
    if($dataI && $dataF != null && $vend->count()>0){
    //pega o itens venda das datas entre a data inicial e data final atraves do whereBetween
    $itensVendas = Itens_Venda::whereBetween('created_at',[$dataI, $dataF])->where('vendas_id', $vend)->get();
   
}
//se tem pelo menos um itens vendas com apenas as datas
 if($itensVendas->count()>0){

        //retorna em formato PDF com todas variáveis
          return \PDF::loadView('relItensVendas', 
                  [
                      'itensVendas'=>$itensVendas,
                      'classes'=>$classes,
                      'vendas'=>$venda,
                      'empresas'=>$empresas,
                      ])->stream();  
    }else  if($vend->count()>0){
   
        //pega o itens venda q tenha o id da venda
        $itensVendas= Itens_Venda::where('vendas_id', '=', $vend)->get();
    
        //retorna em formato PDF com todas variáveis
          return \PDF::loadView('relItensVendas', 
                  [
                      'itensVendas'=>$itensVendas,
                      'classes'=>$classes,
                      'vendas'=>$venda,
                      'empresas'=>$empresas,
                      ])->stream(); 
                      
        }
    else{

        return redirect()->route('relEscolha')
        ->with('status', 'Registro não encontrado!');    

    }

  
   
  }

  public function relEscolhaAno(){

    return view('relatoriosEscolha4');
    
}

public function relAnos (RelEscolha_SafrasFormRequest $request, Venda $vendas, Compra $compras) {    
            
     //pega a data
     $dataForm = $request->all();

     //joga a data pra a função de pesquisa
     $vendas->search($dataForm);
     $compras->search($dataForm);

     //verifica se tem uma compra com o ano
     $c = Compra::whereYear('created_at', '=', $request->data)->get();
     //verifica se tem uma venda com o ano
     $v = Venda::whereYear('created_at', '=', $request->data)->get();
     
   //agrupa os registros com mesma data
   $comp = DB::table('compras')->whereYear('created_at', '=', $request->data)
   ->select(DB::raw('count(*)  as  num, year(created_at) as anos'))
   ->groupBy(DB::raw('year(created_at)'))
   ->get();

//numero de compras feita
$compraID = Compra::whereYear('created_at', '=', $request->data)->count('id');
//soma o total das compras
$compraTotal = Compra::whereYear('created_at', '=', $request->data)->sum('total');

//agrupa os registros com mesma data
$vend = DB::table('vendas')->whereYear('created_at', '=', $request->data)
->select(DB::raw('count(*)  as  num, year(created_at) as anos'))
->groupBy(DB::raw('year(created_at)'))
->get();
//soma o totalQuilo
$vendaTotalQuilo = Venda::whereYear('created_at', '=', $request->data)->sum('totalQuilo');
//soma o total das vendas
$vendaTotal = Venda::whereYear('created_at', '=', $request->data)->sum('total');
//numero de vendas feita
$vendaID = Venda::whereYear('created_at', '=', $request->data)->count('id');


$valorLiquido = $vendaTotal - $compraTotal;

    if($c->count()==0 && $v->count()==0){

        return redirect()->route('relEscolhaAno')
        ->with('status', 'Ano não encontrado!');    
                
    }else if($c->count()==0 && $v->count()>0){
        //calcula a media da safra
        $vendaMedia = $vendaTotal / $vendaTotalQuilo;
        //calcula a media por arroba
        $vendaMediaArroba = $vendaMedia * 15;
            
            // retorna em formato PDF com todas variáveis
            return \PDF::loadView('relSafras', 
            [
                'venda'=>$vend,
                'vendaTotalQuilo'=>$vendaTotalQuilo,
                'vendaTotal'=>$vendaTotal,
                'vendaID'=>$vendaID,
                'vendaMedia'=>$vendaMedia,
                'vendaMediaArroba'=>$vendaMediaArroba,
                'acao'=>1
                ])->stream();

            }else if ($v->count()==0 && $c->count()>0){
                return \PDF::loadView('relSafras',
                [
                    'compra'=>$comp,
                    'compraID'=>$compraID,
                    'compraTotal'=>$compraTotal,
                    'valorLiquido'=>$valorLiquido,
                    'acao' => 2   
                    ])->stream();
                    
            }else if ($c->count()>0 && $v->count()>0){
                //calcula a media da safra
                $vendaMedia = $vendaTotal / $vendaTotalQuilo;
                //calcula a media por arroba
                $vendaMediaArroba = $vendaMedia * 15;

                return \PDF::loadView('relSafras', 
        [
                      'venda'=>$vend,
                      'vendaTotalQuilo'=>$vendaTotalQuilo,
                      'vendaTotal'=>$vendaTotal,
                      'vendaID'=>$vendaID,
                      'vendaMedia'=>$vendaMedia,
                      'vendaMediaArroba'=>$vendaMediaArroba,


                      'compra'=>$comp,
                      'compraID'=>$compraID,
                      'compraTotal'=>$compraTotal,
                      'valorLiquido'=>$valorLiquido,
                      'acao' => 3 
                      ])->stream();
            }
        }
    }

