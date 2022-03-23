<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\order;

class transaksi extends Model
{
    protected $guarded = [];

    protected $fillable = ['subtotal','status'];

    public function order ()
    {
        return $this->hasMany(order::class);
    }
}
