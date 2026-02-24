<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'cover_image'
    ];

    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('order_index');
    }

    public function responses()
    {
        return $this->hasMany(FormResponse::class);
    }
}
