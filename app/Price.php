<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = ['id_produk','harga','area'];

    public function produk()
    {
        return $this->belongsTo(Product::class,'id_produk');
    }
}
