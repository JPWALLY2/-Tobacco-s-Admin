<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Painel\PlantacaoFormRequest;
use App\Plantacao;
use App\Lavoura;
use App\User;

class PlantacoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $plantacoes = Plantacao::orderByDesc('created_at')->paginate(5);

        $soma = Plantacao::sum('quant');  
        
        $lavouras = Lavoura::orderBy('descricao')->get();

        return view ('plantacoes', 
        ['plantacoes'=>$plantacoes, 
        'soma'=>$soma,
        'lavouras' => $lavouras, 
        'acao' => 1, 
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
    public function store(PlantacaoFormRequest $request)
    {

        $dados = $request->all();
        // $plantacoes['lavouras_id'] = $request->get('lavouras_id');
        // $plantacoes['users_id'] = $request->get('users_id');
        // $plantacoes['quant'] = $request->get('quant');
        // $plantacoes['observacao'] = $request->get('observacao');

         //verifica a lavoura existe
        //  $lavoura = Plantacao::where('lavouras_id',$request->lavouras_id)->get();
        //  if($lavoura->count()>0){
        //       return redirect()->route('plantacoes.index')
        //       ->with('status', 'A plantação da lavoura já existe!');
        //   }
        $inc = Plantacao::create($dados);

        if ($inc) {
            return redirect()->route('plantacoes.index');
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

        $reg = Plantacao::find($id);

        $plantacoes = Plantacao::paginate(5);

        $soma = Plantacao::sum('quant');  

        $lavouras = Lavoura::orderBy('descricao')->get();

        $users = User::orderBy('name')->get();
        
        return view('plantacoes',
        [
            'users'=>$users, 
            'reg' => $reg, 
            'lavouras' => $lavouras, 
            'plantacoes' => $plantacoes, 
            'soma' => $soma, 
            'acao' => 2
            ]
        );
    
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlantacaoFormRequest $request, $id)
    {
        $reg = Plantacao::find($id);
        
        $dados = $request->all();

        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('plantacoes.index');
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
        
        $delete = Plantacao::find($id);
        if ($delete->delete()) {
            return redirect()->route('plantacoes.index');
        }
    
    }

    public function pesq(Request $request) {
         
        $acao = 2;
        $dados = Produto::join('lavouras', 'lavouras.id', 'plantacaos.lavouras_id')
                           ->where('plantacaos.id', 'like','%'.$request->palavra.'%')
                           ->orwhere('lavouras.descricao', 'like','%'.$request->palavra.'%')
                           ->select('plantacaos.*')
                           ->get();
        
       return view('admin.plantacaos', compact('acao'), 
       ['dados' => $dados,
        'palavra' => $request->palavra
        ]);
 
   }
}
