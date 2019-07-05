<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Painel\Itens_CompraFormRequest;
use App\Http\Requests\RelEscolha_ItensComprasFormRequest;
use App\Compra;
use App\Empresa;
use App\Insumo;
use App\Itens_Compra;
use Illuminate\Support\Facades\DB;



class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    
    {
        $dados = Compra::orderByDesc('created_at')->paginate(5);

        $soma = Compra::sum('total');     // obtém a soma do campo total

        $numCompras = Compra::count('id');    // obtém o número de registros

        $empresas = Empresa::orderBy('nome')->get();

        return view('compras',
        [
            'compras'=>$dados,
            'soma'=>$soma,
            'numCompras'=>$numCompras,
            'empresas'=>$empresas,
            'acao'=>1
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
    

    public function store(Request $request){


        $dados = $request->all();

        $inc = Compra::create($dados);

        if ($inc) {
            return redirect()->route('compras.index');
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
        $reg = Compra::find($id);

        $empresas = Empresa::orderBy('nome')->get();

        $dados = Compra::paginate(5);
        
        return view('compras', 
        [
            'reg' => $reg, 
            'empresas' => $empresas, 
            'compras' => $dados, 
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
            return redirect()->route('compras.index');
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
        $comp = Compra::find($id);
        if ($comp->delete()) {
            return redirect()->route('compras.index');
        }
    }

    public function index2($id)
    {
        $itensCompras = Itens_Compra::where('compras_id', $id)->paginate(5);
        // $itensCompras = Itens_Compra::paginate(5);

        $insumos = Insumo::orderBy('nome')->get();

        $reg = Compra::find($id);

        $soma = Itens_Compra::where('compras_id', $id)->sum('total');

        $numIC = Itens_Compra::where('compras_id', $id)->count('id');  
        

        return view('itensCompras', 
        [
            'insumos' => $insumos, 
            'itenscompras' => $itensCompras, 
            'reg' => $reg, 
            'soma' => $soma, 
            'numIC' => $numIC, 
            'acao' => 1
        ]
        );
    }

    public function create2(Itens_CompraFormRequest $request, $id)
    {   
        // pega os dados de cada input e direciona para sua tabela específica
        $itensCompras['quant'] = $request->get('quant');
        $itensCompras['preco'] = $request->get('preco');
        $itensCompras['insumos_id'] = $request->get('insumos_id');
        $itensCompras['total'] = $request->get('calc');
        $itensCompras['compras_id'] = $id;

        //pega o id do insumo informado
        $dadosU = $request->insumos_id;
        
        //verifica se o id do insumo existe
        $idI = Itens_Compra::where('compras_id', $id)->where('insumos_id', $dadosU)->get();

        if($idI->count()>0){
            return redirect()->route('indexItensComprados', $id)
            ->with('status', 'O insumo já existe nesta compra!');
        }

        //cadastra na tabela itens_compras os itens
        Itens_Compra::create($itensCompras);

        //pega id da compra
        $regC = Compra::find($id);
        //soma o total
        $regC->total += $request->calc;

        //pega o id do insumo informado no form
        $regI = Insumo::find($request->insumos_id);
        //soma a quant
        $regI->quant += $request->quant;
        $regI->compras_id = $id;
        $regI->preco = $request->preco;


        //atualiza as informações do registro
        $altC = $regC->update();
        $altI = $regI->update();

        //se cadastrou e alterou certo
        if ($itensCompras && $altC && $altI) {
            return redirect()->route('indexItensComprados',$id);
        }
    }   

    public function destroy2($id)
    {
        //pega o id do iten
        $icomp = Itens_Compra::find($id);
        //pega o id da compra do iten
        $id2 = $icomp->compras_id;
        
        //pega o id do insumo do iten
        $id3 = $icomp->insumos_id;

        //pega o total do iten
        $totalIComp = $icomp->total;
        //pega a quant do iten
        $insumoIComp = $icomp->quant;

        //pega a compra do iten
        $compra = Compra::find($id2);
        //subtrai o total 
        $compra->total -= $totalIComp;
        //altera o total da compra
        $altC = $compra->update();

        // pega o insumo do iten
        $insumo = Insumo::find($id3);
        //subtrai a quant
        $insumo->quant -= $insumoIComp;
        //altera a quant do insumo
        $altI = $insumo->update();



        if ($altC && $altI && $icomp->delete()) {
            return redirect()->route('indexItensComprados',$id2);
        }
    }

    public function historico(Compra $compra){

        $dados = Compra::orderByDesc('created_at')->paginate(5);

        $empresas = Empresa::orderBy('nome')->get();

        return view('historicosCompras',
        [
            'compras'=>$dados,
            'empresas'=>$empresas
              ]
            );
    }

    public function pesquisa(Request $request, Compra $compra){

        $dataForm = $request->all();

        $compras = $compra->search($dataForm);

        $empresas = Empresa::orderBy('nome')->get();

        return view('historicosCompras',
        [
            'compras'=>$compras,
            'empresas'=>$empresas
              ]
            );
    }

    public function grafemp() {
        $compras = 
    DB::table('compras')
    ->join('empresas', 'compras.empresas_id', '=', 'empresas.id')
    ->select('empresas.nome as empresas', 
             DB::raw('count(*) as num'))
    ->groupBy('empresas.nome')
    ->get();         

        return view('compras_graf', 
                    ['compras' => $compras]);
    }

    public function relEscolha(){

        $empresas = Empresa::orderBy('nome')->get();

        $insumos = Insumo::orderBy('nome')->get();
    
        return view('relatoriosEscolha2',
        [
            'empresas'=>$empresas,
            'insumos'=>$insumos
              ]
            );
        
    }

    public function relItensCompras(RelEscolha_ItensComprasFormRequest $request, Compra $compras) {
        
        //pega as empresas_id do form
        $dataForm = $request->all();
        
        //pega a data inicial e a data final
        $dataI = $request->dataIni;
        $dataF = $request->dataFin;

        //joga a empresas_id  e o insumos_id para a função de procura na model das compras
        $compra = $compras->search($dataForm);
    
         //pega o itens compras das datas entre a data inicial e data final atraves do whereBetween
         $itensCompras = Itens_Compra::whereBetween('created_at',[$dataI, $dataF])->get();
    
        //pega o id da compra q tenha o id da empresa
        $comp = Compra::where('empresas_id', '=', $request->empresas_id)->pluck('id');
    
        $empresas = Empresa::orderBy('nome')->get();
        $insumos = Insumo::orderBy('nome')->get();

        //se as datas iniciais e finais estiver preenchido e a compra tiver pelomenos um registro
        if($dataI && $dataF != null && $comp->count()>0){
        //pega o itens compra das datas entre a data inicial e data final atraves do whereBetween
        $itensCompras= Itens_Compra::whereBetween('created_at',[$dataI, $dataF])->where('compras_id', $comp)->get();
        }
        
        // se existe um registro de itens compras
        if($itensCompras->count()>0){
    
            //retorna em formato PDF com todas variáveis
              return \PDF::loadView('relItensCompras', 
                      [
                          'itensCompras'=>$itensCompras,
                          'insumos'=>$insumos,
                          'compras'=>$compra,
                          'empresas'=>$empresas,
                          ])->stream();
                          
        }else if($comp->count()>0){
            
        //pega o itens compras q tenha o id da compra
        $itensCompras= Itens_Compra::where('compras_id', '=', $comp)->get();
    
        //retorna em formato PDF com todas variáveis
          return \PDF::loadView('relItensCompras', 
                  [
                      'itensCompras'=>$itensCompras,
                      'insumos'=>$insumos,
                      'compra'=>$compra,
                      'empresas'=>$empresas,
                      ])->stream();    
        }
        else{

            return redirect()->route('relEscolha2')
            ->with('status', 'Registro não encontrado!');
        }
        

        
        
      }

}
