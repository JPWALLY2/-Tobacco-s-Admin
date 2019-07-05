<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plantacao extends Model
{
    protected $fillable = ['quant', 'observacao', 'users_id', 'lavouras_id'];

    public function users() {
        return $this->belongsTo('App\User');
    }
    public function lavouras() {
        return $this->belongsTo('App\Lavoura');
    }

    // retira a máscara com "." e "," antes da inserção 
    public function setQuantAttribute($value) {
        $novo1 = str_replace('.', '', $value);    // retira o ponto
        $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
        $this->attributes['quant'] = $novo2;
    }
}
