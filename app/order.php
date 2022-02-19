<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\transaksi;
use App\katalog;
use App\cart;

class order extends Model
{
    protected $guarded = [];

    protected $fillable = ['transakasi_id','katalog_id','jumlah'];

    public function transaksi()
    {
        return $this->BelongsToMany(transaksi::class);
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
