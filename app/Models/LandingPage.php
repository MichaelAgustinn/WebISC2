<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    // PENTING: Pastikan semua kolom ini ada
    protected $fillable = ['section', 'key', 'value', 'type'];
}
