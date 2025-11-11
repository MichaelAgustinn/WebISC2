<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'nim', 'angkatan', 'jabatan', 'divisi', 'image'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
