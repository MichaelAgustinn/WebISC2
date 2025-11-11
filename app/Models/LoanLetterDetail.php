<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanLetterDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id',
        'perihal',
        'tujuan',
        'dasar_kegiatan',
        'hari',
        'jam',
        'nama_tempat_barang',
    ];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }
}
