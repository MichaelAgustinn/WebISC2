<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Landing_page extends Model
{
    protected $table = 'landing_pages';
    protected $fillable = [
        'section',
        'title',
        'description',
        'image',
    ];
}
