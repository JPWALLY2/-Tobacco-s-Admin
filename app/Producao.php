<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producao extends Model
{
    //erro de tabela não encontrada
    // protected $table = "producoes";

    protected $fillable = ['quilo', 'estoques_id'];

    public function estoques() {
        return $this->belongsTo('App\Estoque');
    }
    public function setQuiloAttribute($value) {
        $novo1 = str_replace('.', '', $value);    // retira o ponto
        $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
        $this->attributes['quilo'] = $novo2;
    }
}
