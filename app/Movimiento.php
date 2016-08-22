<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $dates = ['deleted_at'];
    protected $fillable =  ['codigo', 'receptor', 'dpto', 'cantidad','tipo_mov'];
}
