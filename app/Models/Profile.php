<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Kita gunakan guarded kosong agar semua kolom bisa diisi (mass assignment)
    // Asalkan validasi di controller ketat.
    protected $guarded = ['id'];

    // Relasi Kebalikan: Profile milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
