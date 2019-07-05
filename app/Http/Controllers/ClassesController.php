<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Painel\ClasseFormRequest;
use App\Classe;
use App\Itens_Venda;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classe::paginate(5);

        $numClasses = Classe::count('id');

        return view ('classes', 
        [
            'classes'=>$classes, 
            'numClasses'=>$numClasses,
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
    public function store(ClasseFormRequest $request)
    {  
       $dados = $request->all();

        // pega o nome informado
        $dadosU = $request->nome;
         //verifica se nome existe
        $nome = Classe::where('nome', $dadosU)->get();
        echo $nome;
 
        if($nome->count()>0){
             return redirect()->route('classes.index')
             ->with('status', 'A classe já existe!');
        }

        $cla = Classe::create($dados);

        if ($cla) {
            return redirect()->route('classes.index');
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
        $reg = Classe::find($id);

         //pega o itens venda q tem o id da classe
         $cla = Itens_Venda::where('classes_id', $id)->get();
         //se o count do $ins for 0 
         if($cla->count() > 0){  
            return redirect()->route('classes.index')
            ->with('status', 'A classe não pode ser excluído!');   
         }else if ($reg->delete()) {
            return redirect()->route('classes.index');
        }
    }
}
