<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    public $timestamps = false;
 
    protected $fillable = ['posicaoFolha','quilo'];  


    public function getposicaoFolhaAttribute($value) {
        if ($value=="X") {
            return "X (Baixeiro)";
        } else if ($value == "C") {
            return "C (2º Apanha)";
        } else if ($value == "B") {
            return "B (3º e 4º Apanha)";
        } else if ($value == "T") {
            return "T (Ponteiro)";
        }
    }

    public function setposicaoFolhaAttribute($value) {
        if ($value == "X (Baixeiro)") {
            $this->attributes['posicaoFolha'] = "X";
        } else if ($value == "C (2º Apanha)") {
            $this->attributes['posicaoFolha'] = "C";
        } else if ($value == "B (3º e 4º Apanha)") {
            $this->attributes['posicaoFolha'] = "B";
        } else if ($value == "T (Ponteiro)") {
            $this->attributes['posicaoFolha'] = "T";
        }
    }     
    public static function posicaoFolha() {
        return ['X (Baixeiro)', 'C (2º Apanha)', 'B (3º e 4º Apanha)', 'T (Ponteiro)'];
    }


}
