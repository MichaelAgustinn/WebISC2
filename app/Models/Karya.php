<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karya extends Model
{
    protected $table = 'karya';

    protected $fillable = [
        'judul',
        'deskripsi',
        'image',
        'jumlah_vote',
    ];
}
