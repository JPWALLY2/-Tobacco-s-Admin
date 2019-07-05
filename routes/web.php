<?php

// Route::get('/', function () {
//     return view('vendasanos_graf');
// // });
// })->middleware('auth');
Route::get('/', function () {
    return redirect()->route('vendas.grafanos');
})->middleware('auth');

Auth::routes();
Route::resource('user', 'UserController')->middleware('auth');

Route::group(['prefix'=>'admin', 'middleware' => 'auth'], function () {
    
    Route::resource('empresas', 'EmpresasController');
    Route::resource('estoques', 'EstoquesController');
    Route::resource('instrutores', 'InstrutoresController');
    Route::resource('compras', 'ComprasController');
    Route::resource('tiposInsumos', 'TiposInsumosController');
    Route::resource('insumos', 'InsumosController');
    Route::resource('visitas', 'VisitasController');
    Route::resource('lavouras', 'LavourasController');
    Route::resource('plantacoes', 'PlantacoesController');
    Route::resource('vendas', 'VendasController');
    Route::resource('classes', 'ClassesController');
    Route::resource('producoes', 'ProducoesController');
    Route::resource('marcas', 'MarcasController');
    Route::resource('estimativas', 'EstimativaController');



    //relatorios escolha venda
    Route::get('relEscolha', 'VendasController@relEscolha')
    ->name('relEscolha');
    Route::post('relItensVendas', 'VendasController@relItensVendas')
    ->name('relItensVendas');

    //relatorios escolha anos
    Route::get('relEscolhaAno', 'VendasController@relEscolhaAno')
    ->name('relEscolhaAno');
    Route::post('relAnos', 'VendasController@relAnos')
    ->name('relAnos');

    //relatorios escolha compra
    Route::get('relEscolha2', 'ComprasController@relEscolha')
    ->name('relEscolha2');
    Route::post('relItensComprados', 'ComprasController@relItensCompras')
    ->name('relItensComprados');

    //relatorios escolha insumo
    Route::get('relEscolha3', 'InsumosController@relEscolha')
    ->name('relEscolha3');
    Route::post('relInsumos', 'InsumosController@relInsumos')
    ->name('relInsumos');

    //historico de compras
    Route::get('historicoCompras', 'ComprasController@historico')
    ->name('historicoCompras');
    // filtro do historico
    Route::post('pesquisaHistoricoCompras', 'ComprasController@pesquisa')
    ->name('pesquisaHistoricoCompras');

    //historico de vendas
    Route::get('historicoVendas', 'VendasController@historico')
    ->name('historicoVendas');
    // filtro do historico
    Route::post('pesquisaHistoricoVendas', 'VendasController@pesquisa')
    ->name('pesquisaHistoricoVendas');

    //vendas de fumo
    Route::get('indexFumoVendido/{id}', 'VendasController@index2')
    ->name('indexFumoVendido');

    Route::post('createFumoVendido/{id}', 'VendasController@create2')
    ->name('createFumoVendido');

    Route::delete('destroyFumoVendido/{id}', 'VendasController@destroy2')
    ->name('destroyFumoVendido');


    //itens compras
    Route::get('indexItensComprados/{id}', 'ComprasController@index2')
    ->name('indexItensComprados');

    Route::post('createItensComprados/{id}', 'ComprasController@create2')
    ->name('createItensComprados');

    Route::delete('destroytensComprados/{id}', 'ComprasController@destroy2')
    ->name('destroytensComprados');


    //baixas de insumos
    Route::get('indexBaixasInsumos', 'InsumosController@index2')
    ->name('indexBaixasInsumos');
    
    Route::put('createBaixasInsumos/{id}', 'InsumosController@create2')
    ->name('createBaixasInsumos');
    
    Route::delete('destroyBaixasInsumos/{id}', 'InsumosController@destroy2')
    ->name('destroyBaixasInsumos');


    //graficos vendas
    Route::get('vendasempgraf', 'VendasController@grafemp')
    ->name('vendas.grafemp');

    //grafico anos
    Route::get('vendasanosgraf', 'VendasController@grafanos')
    ->name('vendas.grafanos');

    //graficos compras
    Route::get('comprasempgraf', 'ComprasController@grafemp')
    ->name('compras.grafemp');

    //graficos marcas por insumos
    Route::get('marcasInsumosgraf', 'InsumosController@grafInsMar')
    ->name('compras.grafInsMar');

});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function () {
    return redirect()->route('vendas.grafanos');
})->middleware('auth');

