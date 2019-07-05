<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Painel\EmpresaFormRequest;
use App\Empresa;
use App\Instrutor;
use App\Compra;
use App\Venda;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $empresas = Empresa::paginate(5);
        
        return view ('empresas',
        [
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
    public function store(EmpresaFormRequest $request)
    {
        
        $dados = $request->all();

         // pega o nome informado
         $dadosU = $request->nome;
         //verifica se nome existe
        $nome = Empresa::where('nome', $dadosU)->get();
 
        if($nome->count()>0){
             return redirect()->route('empresas.index')
             ->with('status', 'A empresa já existe!');
         }
       
        $emp = Empresa::create($dados);

        if ($emp) {
            return redirect()->route('empresas.index');
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
        $reg = Empresa::findOrFail($id);/*se nw tiver o registro me retorna 
                                          um erro 404*/
        
        $empresas = Empresa::paginate(5);

        //pega o instrutor q tem o id da empresa        
        $ins = Instrutor::where('empresas_id', $id)->get();
        //pega a compra q tem o id da empresa        
        $com = Compra::where('empresas_id', $id)->get();
        //pega a venda q tem o id da empresa        
        $ven = Venda::where('empresas_id', $id)->get();

        //se o count do $ins for 0 (se não tiver nenhum registro)
        if($ins->count() > 0){  
            return redirect()->route('empresas.index')
            ->with('status', 'A empresa não pode ser alterada!');   
        }
        else if($com->count() > 0){  
            return redirect()->route('empresas.index')
            ->with('status', 'A empresa não pode ser alterada!');   
        }
        else if($ven->count() > 0){  
            return redirect()->route('empresas.index')
            ->with('status', 'A empresa não pode ser alterada!');   
        }
        { 
        return view('empresas', 
        [
            'reg'=>$reg, 
            'acao'=>2, 
            'empresas'=>$empresas
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
    public function update(EmpresaFormRequest $request, $id)
    {

        $reg = Empresa::find($id);

        $dados = $request->all();

        $emp = $reg->update($dados);

        // se alterou
        if ($emp) {
            return redirect()->route('empresas.index');
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
        $empresas = Empresa::find($id);

        //pega o instrutor q tem o id da empresa        
        $ins = Instrutor::where('empresas_id', $id)->get();
        //pega a compra q tem o id da empresa        
        $com = Compra::where('empresas_id', $id)->get();
        //pega a venda q tem o id da empresa        
        $ven = Venda::where('empresas_id', $id)->get();

        //se o count do $ins for 0 
        if($ins->count() > 0){  
            return redirect()->route('empresas.index')
            ->with('status', 'A empresa não pode ser excluída!');   
        }else if ($com->count() > 0) {
            return redirect()->route('empresas.index')
            ->with('status', 'A empresa não pode ser excluída!');
        }else if ($ven->count() > 0) {
            return redirect()->route('empresas.index')
            ->with('status', 'A empresa não pode ser excluída!');
        }else if ($empresas->delete()) {
            return redirect()->route('empresas.index');
        }
    }
}
