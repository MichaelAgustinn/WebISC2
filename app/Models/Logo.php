<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Psy\Readline\Hoa\FileLink;

class Logo extends Model
{
    protected $fillable = ['title', 'image'];
}
