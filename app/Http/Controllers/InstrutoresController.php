<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Painel\InstrutorFormRequest;
use App\Instrutor;
use App\Empresa;
use App\Visita;

class InstrutoresController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instrutores = Instrutor::paginate(5);

        $empresas = Empresa::orderBy('nome')->get();        

        return view('instrutores', 
        [
            'instrutores'=>$instrutores, 
            'empresas' => $empresas, 
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
    public function store(InstrutorFormRequest $request)
    {
        $dados = $request->all();

         // pega o nome informado
         $dadosU = $request->nome;
         // pega o email informado
         $dadosEU = $request->email;
         // pega o telefone informado
         $dadosTU = $request->telefone;
         //verifica se nome existe
        $nome = Instrutor::where('nome', $dadosU)->get();
         //verifica se email existe
        $email = Instrutor::where('email', $dadosEU)->get();
         //verifica se telefone existe
        $telefone = Instrutor::where('telefone', $dadosTU)->get();
 
        if($nome->count()>0){
            return redirect()->route('instrutores.index')
            ->with('status', 'O nome do instrutor já existe!');
         }else if($email->count()>0){
            return redirect()->route('instrutores.index')
            ->with('status', 'O email do instrutor já existe!');
         }else if($telefone->count()>0){
            return redirect()->route('instrutores.index')
            ->with('status', 'O telefone do instrutor já existe!');
         }

        $inc = Instrutor::create($dados);

        if ($inc) {
            return redirect()->route('instrutores.index');
          
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
        $reg = Instrutor::findOrFail($id);

        $empresas = Empresa::orderBy('nome')->get();

        $instrutores = Instrutor::paginate(5);
        //pega o visita q tem o id do tipo
        $vis = Visita::where('instrutors_id', $id)->get();
        
         //se o count do $ins for 0 
         if($vis->count() > 0){  
            return redirect()->route('instrutores.index')
            ->with('status', 'O instrutor não pode ser alterado!');   
        }{ 
        return view('instrutores', [
            'reg' => $reg, 
            'empresas' => $empresas, 
            'instrutores' => $instrutores,
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
    public function update(InstrutorFormRequest $request, $id)
    {
        $dados = $request->all();
        
        $reg = Instrutor::find($id);

        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('instrutores.index');
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
        $instrutor = Instrutor::find($id);

        //pega a visita q tem o id do tipo
         $vis = Visita::where('instrutors_id', $id)->get();
        
         //se o count do $ins for 0 
        if($vis->count() > 0){  
            return redirect()->route('instrutores.index')
            ->with('status', 'O instrutor não pode ser excluído!'); 
        }else if($instrutor->delete()) {
            return redirect()->route('instrutores.index');
                           
        }
    }
}
