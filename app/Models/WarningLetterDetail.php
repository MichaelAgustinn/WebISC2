<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarningLetterDetail extends Model
{
    protected $fillable = ['letter_id', 'peringatan_ke'];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
