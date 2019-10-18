<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{

    protected $fillable =['nombre','descripcion'];

    public function clientes2() {
        return $this->belongsTo('App\Clientes2');
    }
}
