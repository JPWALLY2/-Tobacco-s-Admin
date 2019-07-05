<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producao;
use App\Estoque;

class ProducoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producoes = Producao::orderByDesc('created_at')->paginate(5);

        $soma = Producao::sum('quilo');  

        $estoques = Estoque::orderBy('posicaoFolha')->get();

        return view ('producoes',
        [
            'soma' => $soma,
            'estoques' => $estoques,
            'producoes' => $producoes,
            'acao' => 1
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producoes['estoques_id'] = $request->get('estoques_id');
        $producoes['quilo'] = $request->get('quilo');
             
        $pro = Producao::create($producoes);

        //pega o estoque correspondente ao estoques_id da produção
        $reg = Estoque::find($request->estoques_id);

        //troca a , por .
        $novo1 = str_replace('.', '', $request->quilo); 
        $novo2 = str_replace(',', '.', $novo1); 
        
        //faz a soma
        $totalQ = $reg->quilo += $novo2;

        //atualiza a informação do registro
        $alt = $reg->update();

        if ($producoes && $alt) {
            return redirect()->route('producoes.index');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //pega o id do estoque
        $prod = Producao::find($id);

        //pega o id do estoque do produto
        $id2 = $prod->estoques_id;
        
        //pega o quilo da producao
        $quiloP = $prod->quilo;

        //pega o estoque pelo id do id2
        $est = Estoque::find($id2);

        //pega o quilo do estoque e subtrai
        $est->quilo -= $quiloP;

        //altera o quilo do estoque
        $altP = $est->update();

        if ($altP && $prod->delete()){
            return redirect()->route('producoes.index');
        }



    }
}
