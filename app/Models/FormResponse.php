<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormResponse extends Model
{
    protected $fillable = ['form_id', 'user_id'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function answers()
    {
        return $this->hasMany(FormAnswer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
