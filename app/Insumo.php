<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $fillable = ['nome', 'tiposInsumos_id', 'marcas_id',
    'preco', 'descricao', 'quant'];

    public function tiposInsumos() {
        return $this->belongsTo(TiposInsumo::class, 'tiposInsumos_id');
    }
    public function marcas() {
        return $this->belongsTo(Marca::class, 'marcas_id');
    }
     // retira a máscara com "." e "," antes da inserção 
     public function setPrecoAttribute($value) {
        $novo1 = str_replace('.', '', $value);    // retira o ponto
        $novo2 = str_replace(',', '.', $novo1);   // substitui a , por .
        $this->attributes['preco'] = $novo2;
    }

     //criar o metodo search
    //variavel data é um array com as opções de filtro
    public function search(Array $data){
        //função calback
        $hist = $this->where(function ($query) use ($data){
            //isset (se existe)

            if (isset($data['tiposInsumos_id']))
            $query->where('tiposInsumos_id', $data['tiposInsumos_id']);

            if (isset($data['insumos_id']))
            $query->where('id', $data['insumos_id']);

            if (isset($data['marcas_id']))
            $query->where('marcas_id', $data['marcas_id']);
            
        })
        ->paginate(5);

        return $hist;

    }
}
