<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable = [
        'jenis_surat',
        'tanggal',
        'nomor_surat',
        'nama_ketua',
        'jabatan_ketua'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'letter_user');
    }

    public function warningDetail()
    {
        return $this->hasOne(WarningLetterDetail::class);
    }

    public function loanDetail()
    {
        return $this->hasOne(LoanLetterDetail::class);
    }
}
