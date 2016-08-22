<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Und extends Model
{
    protected $table = 'unds';
    protected $dates = ['deleted_at'];
    protected $fillable =  ['nombre'];
}
