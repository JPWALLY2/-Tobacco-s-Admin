<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Painel\TiposInsumoFormRequest;
use App\Insumo;
use App\TiposInsumo;

class TiposInsumosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposInsumos = TiposInsumo::paginate(5);

        return view ('tiposInsumos', 
        [
            'tiposInsumos'=>$tiposInsumos,
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TiposInsumoFormRequest $request)
    {
        $dados = $request->all();

         // pega o nome informado
        $dadosU = $request->nome;
         //verifica se nome existe
        $nome = TiposInsumo::where('nome', $dadosU)->get();
 
        if($nome->count()>0){
             return redirect()->route('tiposInsumos.index')
             ->with('status', 'O tipo de Insumo já existe!');
         }
         
         $tin = TiposInsumo::create($dados);

        if($tin){
            return redirect()->route('tiposInsumos.index');
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
        $reg = TiposInsumo::findOrFail($id);
        
        $tiposInsumos = TiposInsumo::paginate(5);

        //pega o insumo q tem o id do tipo
        $ins = Insumo::where('tiposInsumos_id', $id)->get();

        //se o count do $ins for 0 
        if($ins->count() > 0){  
            return redirect()->route('tiposInsumos.index')
            ->with('status', 'O tipo de insumo não pode ser alterado!');   
        }{      
        return view('tiposInsumos',
         [
                'reg'=>$reg, 
                'tiposInsumos'=>$tiposInsumos, 
                'acao'=>2
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
    public function update(TiposInsumoFormRequest $request, $id)
    {
        $reg = TiposInsumo::find($id);

        $dados = $request->all();

        $tin = $reg->update($dados);

        //se alterou
        if($tin){
            return redirect()->route('tiposInsumos.index');
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
        $tiposInsumos = TiposInsumo::find($id);

        //pega o insumo q tem o id do tipo
        $ins = Insumo::where('tiposInsumos_id', $id)->get();
        //se o count do $ins for 0 
        if($ins->count() > 0){  
            return redirect()->route('tiposInsumos.index')
            ->with('status', 'O tipo de insumo não pode ser excluído!');   
        }else if($tiposInsumos->delete()){
            return redirect()->route('tiposInsumos.index');        
        }
       
    }
}
