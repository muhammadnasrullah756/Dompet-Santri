<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Saldo extends Model
{
    protected $fillable = [
        'nominal', 'type_id', 'pict','status','user_id', 'type'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
