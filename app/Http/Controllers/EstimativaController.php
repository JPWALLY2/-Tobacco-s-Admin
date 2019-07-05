<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EstimativaFormRequest;


use App\Estimativa;

class EstimativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estimativa = Estimativa::paginate(5);
        return view('estimativa',
    [
        'estimativas'=>$estimativa
    ]);
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
    public function store(EstimativaFormRequest $request)
    {
         $estimativa['quant'] = $request->get('quant');
         $estimativa['arroba'] = $request->get('arroba');
         $estimativa['media'] = $request->get('media');
         $estimativa['valorInsumo'] = $request->get('valorInsumo');
        
        //faz a multiplicação de arrobas e 15kg (uma arroba)
        $multi = $request->arroba * 15;
        //tira o ponto e virgula da qunatidade
        $novoQ1 = str_replace(',', '.', $request->quant);
        $novoQ2 = str_replace('.', '', $novoQ1);
        //multiplica o total de quilos
        $totalQ = ($multi * $novoQ2) / 100000;
        number_format($totalQ, 2, ',', '.');

        //multiplica o total de quilos para calculo
        $totalQuilo = ($multi * $novoQ2) / 1000000;
        
        $estimativa['totalQuilo'] = $totalQ;

        //tira o ponto e virgula da media
        $novoM1 = str_replace(',', '.', $request->media);
        $novoM2 = str_replace('.', '', $novoM1);
        //multiplica o valor total
        $valorT = ($totalQuilo * $novoM2) / 100;

        $valorTCalculo = ($totalQuilo * $novoM2);
        number_format($valorT, 2, ',', '.');

        $estimativa['valorTotal'] = $valorT;

        //tira o ponto e virgula do valor do insumo
        $novo1 = str_replace(',', '.', $request->valorInsumo);
        $novo2 = str_replace('.', '', $novo1);

        $subTotal = ($valorTCalculo - $novo2) / 100;

        number_format($subTotal, 2, ',', '.');

        $estimativa['subTotal'] = $subTotal;


        $est = Estimativa::create($estimativa);
        
        if($est){
            return redirect()->route('estimativas.index');
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
        $estimativas = Estimativa::find($id);

    if ($estimativas->delete()) {
        
        return redirect()->route('estimativas.index');
    }
    }
}
