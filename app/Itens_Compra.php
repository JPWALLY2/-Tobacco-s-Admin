<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itens_Compra extends Model
{
    protected $fillable = ['quant', 'preco', 'total', 'compras_id', 'insumos_id'];

    public function compras() {
        return $this->belongsTo('App\Compra');
    }
    public function empresas() {
        return $this->belongsTo('App\Empresa');
    }
    public function insumos() {
        return $this->belongsTo('App\Insumo');
    }

    // retira a máscara com "." e "," antes da inserção 
    public function setPrecoAttribute($value) {
        $novo1 = str_replace('.', '', $value);    // retira o ponto
        $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
        $this->attributes['preco'] = $novo2;
    }
}
