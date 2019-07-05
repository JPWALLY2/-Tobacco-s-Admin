<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = ['total', 'empresas_id'];

    public function empresas() {
        return $this->belongsTo('App\Empresa');
    }

    //criar o metodo search
    //variavel data é um array com as opções de filtro
    public function search(Array $data){
        //função calback
        $hist = $this->where(function ($query) use ($data){
            //isset (se existe)
            if (isset($data['date']))
            $query->whereDate('created_at', $data['date']);

            if (isset($data['data']))
            $query->whereYear('created_at', $data['data']);

            if (isset($data['empresas_id']))
            $query->where('empresas_id', $data['empresas_id']);

            if (isset($data['total'])) {

                $strTotal = str_replace('.', '', $data['total']);
                $strTotal = str_replace(',', '.', $strTotal);
                
                $query->where('total', $strTotal);
            }
            
        })
        ->paginate(5);

        return $hist;

    }

}
