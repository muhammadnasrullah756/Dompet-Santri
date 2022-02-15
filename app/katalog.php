<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class katalog extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'gambar_barang','nama_barang','harga_barang'
    ];
}
