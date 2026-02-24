<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = ['form_id', 'label', 'image', 'type', 'is_required', 'order_index'];
}
