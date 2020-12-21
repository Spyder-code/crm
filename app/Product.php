<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['nama','deskripsi','stock','status','link','image','berat'];

    public function image()
    {
        return $this->hasMany(Image::class,'id_produk');
    }
}
