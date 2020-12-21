<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    protected $fillable = ['member_id','referal_id','status'];

    public function member()
    {
        return $this->belongsTo(User::class,'member_id');
    }

    public function pengikut()
    {
        return $this->belongsTo(User::class,'referal_id');
    }
}
