<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Painel\LavouraFormRequest;
use App\Lavoura;
use App\Plantacao;

class LavourasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lavouras = Lavoura::paginate(5);

        $numLavouras = Lavoura::count('id'); 

        return view('lavouras', [
            'lavouras'=>$lavouras, 
            'numLavouras'=>$numLavouras,
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
    public function store(LavouraFormRequest $request)
    {
        $dados = $request->all();
         // pega a descricao informado
         $dadosU = $request->descricao;
         //verifica se nome existe
        $descricao = Lavoura::where('descricao', $dadosU)->get();
 
        if($descricao->count()>0){
             return redirect()->route('lavouras.index')
             ->with('status', 'O nome/descrição da lavoura já existe!');
         }

        $inc = Lavoura::create($dados);

        if ($inc) {
            return redirect()->route('lavouras.index');
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
        $reg = Lavoura::findOrFail($id);

        $lavouras = Lavoura::paginate(5);

        $numLavouras = Lavoura::count('id'); 

        //pega a plantação q tem o id da lavoura
        $pla = Plantacao::where('lavouras_id', $id)->get();

        //se o count do $pla for 0 
        if($pla->count() > 0){  
            return redirect()->route('lavouras.index')
            ->with('status', 'A lavoura não pode ser alterada!');   
        }{      
        return view('lavouras',
         [
             'reg' => $reg, 
             'lavouras'=>$lavouras,
             'numLavouras'=>$numLavouras,
             'acao' =>2 
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
    public function update(LavouraFormRequest $request, $id)
    {
        $dados = $request->all();

        $reg = Lavoura::find($id);

        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('lavouras.index');
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
        $lavouras = Lavoura::find($id);

        //pega a plantação q tem o id da lavoura
        $pla = Plantacao::where('lavouras_id', $id)->get();
        //se o count do $pla for 0 
        if($pla->count() > 0){  
            return redirect()->route('lavouras.index')
            ->with('status', 'A lavoura não pode ser escluído!');   
        }else if ($lavouras->delete()) {
            return redirect()->route('lavouras.index');
        }
    }
}
