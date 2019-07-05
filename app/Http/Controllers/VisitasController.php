<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Painel\VisitaFormRequest;
use App\Visita;
use App\Instrutor;


class VisitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitas = Visita::orderByDesc('created_at')->paginate(5);

        $instrutores = Instrutor::orderBy('nome')->get();

        return view('visitas', 
        [
            'visitas'=>$visitas,
            'instrutores'=>$instrutores,
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
    public function store(VisitaFormRequest $request)
    {
        $dados = $request->all();

        $inc = Visita::create($dados);

        if ($inc) {
            return redirect()->route('visitas.index');
                //  ->with('status', 'Visita inserido com sucesso!');
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
        $reg = Visita::find($id);

        $visitas = Visita::paginate(5);

        $instrutores = Instrutor::orderBy('nome')->get();
        
        return view('visitas', 
        [
            'reg' => $reg, 
            'visitas' => $visitas,
            'instrutores' => $instrutores,
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
    public function update(VisitaFormRequest $request, $id)
    {
        $dados = $request->all();

        $reg = Visita::find($id);


        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('visitas.index');
                            // ->with('status', 'Visita Alterada!');
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
        $reg = Visita::find($id);

        if ($reg->delete()) {
            return redirect()->route('visitas.index');
                // ->with('status','visita excluída corretamente!!');
        }
    }
}
