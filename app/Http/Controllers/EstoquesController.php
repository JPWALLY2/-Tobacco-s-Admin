<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Estoque;
use App\Itens_Venda;
class EstoquesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estoques = Estoque::paginate(5);

        $soma = Estoque::sum('quilo');  

        $posicaoFolhas = Estoque::posicaoFolha();

        return view ('estoques',
        [
            'soma'=>$soma,
            'posicaoFolhas'=>$posicaoFolhas,
            'estoques'=>$estoques, 
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
    public function store(Request $request)
    {
        $dados = $request->all();

         //pega a posicao da folha informado
        $palavra = $request->posicaoFolha;
         
        // primeiro número é a posição da palavra 
        // onde você quer começar a pegar a string
        // o segundo número é a quantidade de caracteres
        // a partir daquele ponto que vai ser a string
        $priPF = substr($palavra,0,1);
        
        //  verifica se a posição da folha existe
        $pf = Estoque::where('posicaoFolha', $priPF)->get();
 
         if($pf->count()>0){
             return redirect()->route('estoques.index')
             ->with('status', 'O estoque desta posição de folha já existe!');
         }
       
        $est = Estoque::create($dados);

        if ($est) {
            return redirect()->route('estoques.index');
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
        $reg = Estoque::find($id);

        $estoques = Estoque::paginate(5);

        $soma = Estoque::sum('quilo');    

        $posicaoFolhas = Estoque::posicaoFolha();

        //pega o iten vendido q tem o id do estoque
        $iVen = Itens_Venda::where('estoques_id', $id)->get();
        

         //se o count do $ins for 0 (se não tiver nenhum registro)
         if($iVen->count() > 0){  
            return redirect()->route('estoques.index')
            ->with('status', 'O estoque não pode ser alterada!');   
        }
        {
        return view('estoques',
        [
            'reg' => $reg, 
            'estoques' => $estoques, 
            'posicaoFolhas' => $posicaoFolhas, 
            'soma' => $soma, 
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
    public function update(Request $request, $id)
    {
        $reg = Estoque::find($id);

        $dados = $request->all();

        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('estoques.index');
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
        $reg = Estoque::find($id);

        //pega o iten vendido q tem o id do estoque
        $iVen = Itens_Venda::where('estoques_id', $id)->get();
        

         //se o count do $ins for 0 (se não tiver nenhum registro)
         if($iVen->count() > 0){  
            return redirect()->route('estoques.index')
            ->with('status', 'O estoque não pode ser excluído!');   
        }else if ($reg->delete()) {
            return redirect()->route('estoques.index');
        }
    }
}
