<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['id_pembeli','id_member','id_produk','id_harga','jumlah','ongkir','total','status','kode'];

    public function member()
    {
        return $this->belongsTo(User::class,'id_member');
    }

    public function pembeli()
    {
        return $this->belongsTo(Customer::class,'id_pembeli');
    }

    public function harga()
    {
        return $this->belongsTo(Price::class,'id_harga');
    }

    public function produk()
    {
        return $this->belongsTo(Product::class,'id_produk');
    }
}
