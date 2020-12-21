<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['nama','alamat','email','phone','status','panggilan','sapaan'];
}
