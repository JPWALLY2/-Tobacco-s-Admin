<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Painel\InsumoFormRequest;
use Illuminate\Support\Facades\DB;
use App\Insumo;
use App\TiposInsumo;
use App\Itens_Compra;
use App\Saidas_Itens;
use App\Marca;
class InsumosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $insumos = Insumo::orderByDesc('created_at')->paginate(5);

        $tin = TiposInsumo::orderBy('nome')->get();   

        $marcas = Marca::orderBy('nome')->get();       
        
        return view('insumos', 
        [
            'insumos'=>$insumos,
            'tin'=>$tin,
            'marcas'=>$marcas,
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
    public function store(InsumoFormRequest $request)
    {
        $dados = $request->all();

         //verifica se nome existe
        $nome = Insumo::where('nome', $request->nome)->where('marcas_id', $request->marcas_id)->get();
 
        if($nome->count()>0){
             return redirect()->route('insumos.index')
             ->with('status', 'O Insumo já existe!');
        }
        
        $inc = Insumo::create($dados);

        if ($inc) {
            return redirect()->route('insumos.index');
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
        $reg = Insumo::find($id);

        $tin = TiposInsumo::orderBy('nome')->get();

        $marcas = Marca::orderBy('nome')->get();

        $insumos = Insumo::paginate(5);

        //pega a saida q tem o id do insumo
        $sai = Saidas_itens::where('insumos_id', $id)->get();
        //pega o item comprado q tem o id do insumo
        $Ico = Itens_Compra::where('insumos_id', $id)->get();

        //se o count do $sai for 0 
        if($sai->count() > 0){  
            return redirect()->route('insumos.index')
            ->with('status', 'O insumo não pode ser alterado!');   
        }else if($Ico->count() > 0){  
            return redirect()->route('insumos.index')
            ->with('status', 'O insumo não pode ser alterado!');   
        }
        {     
        return view('insumos',
         [
             'reg' => $reg, 
             'tin' => $tin, 
             'marcas' => $marcas, 
             'insumos' => $insumos, 
             'acao' => 2
             ]
        );
    }
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InsumoFormRequest $request, $id)
    {
        $dados = $request->all();

        $reg = Insumo::find($id);

        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('insumos.index');
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
        $insumos = Insumo::find($id);

         //pega a saida q tem o id do insumo
         $sai = Saidas_itens::where('insumos_id', $id)->get();
         //pega o item comprado q tem o id do insumo
         $Ico = Itens_Compra::where('insumos_id', $id)->get();
 
         //se o count do $sai for 0 
         if($sai->count() > 0){  
             return redirect()->route('insumos.index')
             ->with('status', 'O insumo não pode ser excluído!');   
         //se o count do $Ico for 0          
        }else if($Ico->count() > 0){  
             return redirect()->route('insumos.index')
             ->with('status', 'O insumo não pode ser excluído!');   
         }else if ($insumos->delete()) {
            return redirect()->route('insumos.index');
        }
    }
    
    public function index2()
    {
        $insumos = Insumo::where('quant', '>', 0)->orderBy('nome')->get();

        $baixarInsumos = Saidas_Itens::orderByDesc('created_at')->paginate(5);

        return view('baixarInsumos', 
        [
            'insumos' => $insumos, 
            'baixarInsumos' => $baixarInsumos, 
            ]);
    }

    public function create2(Request $request, $id)
    {
        
        $dadosSI = $request->all();
        
        $insumo['quant'] = $request->get('quant');
        
        //gambiarra de pegar o id certo do insumo ja que o id ta pegand só um
        $id2 = $request->insumos_id;

        $reg = Insumo::find($id2);

        $reg->quant -= $request->quant;
        
        $alt = $reg->update();
        $inc = Saidas_Itens::create($dadosSI);

        if ($alt && $inc) {
            return redirect()->route('indexBaixasInsumos');
        }
    }
    public function destroy2($id)
    {
        //pega o id do iten
        $saidaI = Saidas_Itens::find($id);
        //pega o id do insumo do iten
        $id2 = $saidaI->insumos_id;

        //pega a quant do iten
        $insumoIsaida = $saidaI->quant;

        // pega o insumo do iten
        $insumo = Insumo::find($id2);
        //subtrai a quant
        $insumo->quant += $insumoIsaida;
        //altera a quant do insumo
        $altSI = $insumo->update();


        if ($altSI && $saidaI->delete()) {
            return redirect()->route('indexBaixasInsumos');
        }
    }
    public function grafInsMar() {
      
        $insumos = DB::table('insumos')
        ->join('marcas', 'insumos.marcas_id', '=', 'marcas.id')
    ->select('marcas.nome as marcas', 
             DB::raw('count(*) as num'))
    ->groupBy('marcas.nome')
    ->get();  
    
        return view('marcasInsumos_graf',
        ['insumos' => $insumos]);
         }

         public function relEscolha(){

            $tiposInsumos = TiposInsumo::orderBy('nome')->get();

            $marcas = Marca::orderBy('nome')->get();

            $insumos = Insumo::orderBy('nome')->get();
        
            return view('relatoriosEscolha3',
            [
                'tiposInsumos'=>$tiposInsumos,
                'insumos'=>$insumos,
                'marcas'=>$marcas
                  ]
                );
            
        }

        public function relInsumos(Request $request, Insumo $insumos) {      
            if($request->marcas_id == null && $request->tiposInsumos_id == null ){
               
            return redirect()->route('relEscolha3')
                ->with('status1', 'O Campo tipo é obrigatório!')
                ->with('status', 'O Campo marca é obrigatório!');  
            }else{
            
            //pega as empresas_id do form
            $dataForm = $request->all();
        
            //joga os dados para a função de procura na model dos insumos
            $insumo = $insumos->search($dataForm);
        
            $tiposInsumos = TiposInsumo::orderBy('nome')->get();
            $marcas = Marca::orderBy('nome')->get();

            if($insumo->count()==0){
            
            return redirect()->route('relEscolha3')
        ->with('status', 'Insumo não encontrado!')  
        ->with('status1', 'Insumo não encontrado!');  
                }else{      
            //retorna em formato PDF com todas variáveis  
            return \PDF::loadView('relInsumo', 
      [
          'insumo'=>$insumo,
          'tiposInsumos'=>$tiposInsumos,
          'marcas'=>$marcas,
          ])->stream(); 
        }
    }
    }
}
