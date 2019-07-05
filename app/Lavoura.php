<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lavoura extends Model
{
    protected $fillable = ['descricao', 'hectares'];

      // retira a máscara com "." e "," antes da inserção 
      public function setHectareAttribute($value) {
        $novo1 = str_replace('.', '', $value);    // retira o ponto
        $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
        $this->attributes['hectares'] = $novo2;
    }
}
