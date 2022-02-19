<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $guarded = [];

    protected $fillable = ['order_id'];

    public function order ()
    {
        return $this->HasMany(order::class);
    }
}
