<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itens_Venda extends Model
{
    protected $fillable = ['quilo', 'totalQuilo', 'preco', 'vendas_id', 'classes_id', 'total', 'estoques_id'];

    public function vendas() {
        return $this->belongsTo('App\Venda');
    }
    public function classes() {
        return $this->belongsTo('App\Classe');
    }
    public function estoques() {
        return $this->belongsTo('App\Estoque');
    }

    // retira a máscara com "." e "," antes da inserção 
    public function setPrecoAttribute($value) {
        $novo1 = str_replace('.', '', $value);    // retira o ponto
        $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
        $this->attributes['preco'] = $novo2;
    }
    public function setQuiloAttribute($value) {
        $novo1 = str_replace('.', '', $value);    // retira o ponto
        $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
        $this->attributes['quilo'] = $novo2;
    }
    public function setTotalQuiloAttribute($value) {
        $novo1 = str_replace('.', '', $value);    // retira o ponto
        $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
        $this->attributes['totalQuilo'] = $novo2;
    }

       //criar o metodo procurar
    //variavel data é um array com as opções de filtro
    public function procurar(Array $data){
        //função calback
        $hist = $this->where(function ($query) use ($data){
            // isset (se existe)
            if (isset($data['data']))
            $query->whereYear('created_at', $data['data']);
            
        })
        ->paginate(5);

        return $hist;

    }
    
}
