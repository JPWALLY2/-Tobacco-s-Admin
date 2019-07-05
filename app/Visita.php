<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $fillable = ['motivo', 'observacao', 'instrutors_id'];

    public function instrutors() {
        return $this->belongsTo('App\Instrutor');
    }

}
