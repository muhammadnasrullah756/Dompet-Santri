<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\transaksi;
use App\katalog;
use App\cart;

class order extends Model
{
    protected $guarded = [];

    protected $fillable = ['transaksi_id','katalog_id','jumlah'];

    public function transaksi()
    {
        return $this->belongsTo(transaksi::class);
    }

    public function katalog ()
    {
        return $this->belongsToMany(katalog::class);
    }

    public function cart()
    {
        return $this->belongsToMany(cart::class);
    }
}
