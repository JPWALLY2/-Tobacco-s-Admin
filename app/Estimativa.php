<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estimativa extends Model
{
    public $timestamps = false;

    protected $fillable = ['arroba', 'quant', 'totalQuilo', 'media', 'valorTotal',
'valorInsumo', 'subTotal'];  

public function setQuantAttribute($value) {
    $novo1 = str_replace('.', '', $value);    // retira o ponto
    $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
    $this->attributes['quant'] = $novo2;
}
// public function settotalQuiloAttribute($value) {
//     $novo1 = str_replace('.', '', $value);    // retira o ponto
//     $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
//     $this->attributes['totalQuilo'] = $novo2;
// }
public function setMediaAttribute($value) {
    $novo1 = str_replace('.', '', $value);    // retira o ponto
    $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
    $this->attributes['media'] = $novo2;
}
// public function setvalorTotalAttribute($value) {
//     $novo1 = str_replace('.', '', $value);    // retira o ponto
//     $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
//     $this->attributes['valorTotal'] = $novo2;
// }
public function setvalorInsumoAttribute($value) {
    $novo1 = str_replace('.', '', $value);    // retira o ponto
    $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
    $this->attributes['valorInsumo'] = $novo2;
}
// public function setsubTotalAttribute($value) {
//     $novo1 = str_replace('.', '', $value);    // retira o ponto
//     $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
//     $this->attributes['subTotal'] = $novo2;
// }

}
