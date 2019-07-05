<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MarcaFormRequest;
use App\Marca;
use App\Insumo;

class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = Marca::paginate(5);

        $numMarcas = Marca::count('id'); 

        return view('marcas', [
            'marcas'=>$marcas, 
            'numMarcas'=>$numMarcas,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarcaFormRequest $request)
    {
        $dados = $request->all();
        
         //verifica se nome existe
        $nome = Marca::where('nome',$request->nome)->get();
        if($nome->count()>0){
             return redirect()->route('marcas.index')
             ->with('status', 'O nome da marca já existe!');
         }

        $inc = Marca::create($dados);

        if ($inc) {
            return redirect()->route('marcas.index');
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
        $reg = Marca::find($id);

        $marcas = Marca::paginate(5);

        $numMarcas = Marca::count('id'); 

         //pega o insumo q tem o id da marca
         $in = Insumo::where('marcas_id', $id)->get();

         //se o count do $pla for 0 
         if($in->count() > 0){  
             return redirect()->route('marcas.index')
             ->with('status', 'A marca não pode ser alterada!');   
         }{      
        return view('marcas', [
            'marcas'=>$marcas, 
            'reg'=>$reg, 
            'numMarcas'=>$numMarcas,
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
    public function update(MarcaFormRequest $request, $id)
    {
        $dados = $request->all();
        
        $reg = Marca::find($id);

        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('marcas.index');
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
        $marcas = Marca::find($id);

        //pega o insumo q tem o id da marca
        $ins = Insumo::where('marcas_id', $id)->get();
        //se o count do $ins for 0 
        if($ins->count() > 0){  
            return redirect()->route('marcas.index')
            ->with('status', 'A marca não pode ser escluído!');   
        }else if ($marcas->delete()) {
            return redirect()->route('marcas.index');
        }
    }
    
}
