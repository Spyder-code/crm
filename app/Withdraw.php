<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = ['id_member','jumlah','status'];

    public function member()
    {
        return $this->belongsTo(User::class,'id_member');
    }
}
