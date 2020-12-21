<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['id_produk','jumlah'];

    public function produk()
    {
        return $this->belongsTo(Product::class,'id_produk');
    }
}
