<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    protected $fillable = [
        'nominal', 'type_id', 'pict','status'
    ];
}
