<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regist extends Model
{
    protected $fillable = ['name', 'email', 'password', 'nim', 'phone_number', 'angkatan'];
}
