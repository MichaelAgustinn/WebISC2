<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['rating', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
