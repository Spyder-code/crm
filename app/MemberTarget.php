<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberTarget extends Model
{
    protected $fillable = ['id_target','id_member'];
}
