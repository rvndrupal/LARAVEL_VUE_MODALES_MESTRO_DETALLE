<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes2 extends Model
{
    protected $table = 'clientes2';
    protected $fillable = ['nom','ap','am','total','cursos_id'];


    public function cursos() {
        return $this->hasMany('App\Cursos', 'clientes2_id');
    }


}
