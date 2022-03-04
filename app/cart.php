<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $guarded = [];

    protected $fillable = ['order_id','katalog_id','jumlah'];

    public function order ()
    {
        return $this->belongsTo(order::class);
    }
}
