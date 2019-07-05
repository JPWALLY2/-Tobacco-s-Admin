<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saidas_Itens extends Model
{

    // erro de tabela nw existe
    protected $table = 'saidas_itens'; 
    
    protected $fillable = ['motivo', 'quant', 'insumos_id'];

    public function Insumos() {
        return $this->belongsTo(Insumo::class, 'insumos_id');
    }
}
