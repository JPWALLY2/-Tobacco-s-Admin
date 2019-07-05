<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instrutor extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['nome', 'email', 'telefone', 'empresas_id'];

    public function empresas() {
            return $this->belongsTo('App\Empresa');
        }
        
        // public function setTelefoneAttribute($value) {
        //     $novo1 = preg_replace("/\D+/", "", $value); 
        //     $this->attributes['telefone'] = $novo1;
            
        // }

        public function setTelefoneAttribute($value) {
            $novo1 = str_replace('(', '', $value); 
            $novo2 = str_replace(')', '', $novo1); 
            $novo3 = str_replace('-', '', $novo2);
            $this->attributes['telefone'] = $novo3;
        }
    
}
