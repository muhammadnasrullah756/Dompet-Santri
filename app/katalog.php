<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\order;

class katalog extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'gambar_barang','nama_barang','harga_barang'
    ];

    public function order()
    {
        return $this->HasMany(order::class);
    }
}
