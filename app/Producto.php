<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'productos';
    protected $dates = ['deleted_at'];
    protected $fillable =  ['codigo', 'nombre', 'stock', 'und'];

}
