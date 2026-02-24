<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormAnswer extends Model
{
    protected $fillable = ['form_response_id', 'form_field_id', 'answer_text', 'answer_file'];

    public function response()
    {
        return $this->belongsTo(FormResponse::class, 'form_response_id');
    }

    public function field()
    {
        return $this->belongsTo(FormField::class, 'form_field_id');
    }
}
