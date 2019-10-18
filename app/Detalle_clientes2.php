<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_clientes2 extends Model
{
    protected $table = 'detalle_clientes2';

    protected $fillable = ['clientes2_id','cursos_id','cantidad','precio'];
}
