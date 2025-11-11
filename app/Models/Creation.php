<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creation extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'content', 'divisi', 'status'];

    public function getFirstImageAttribute()
    {
        // Ambil gambar utama jika kolom `image` ada
        if (!empty($this->image)) {
            return $this->image;
        }

        // Jika tidak ada, coba ambil <img> pertama dari konten
        if (preg_match('/<img[^>]+src="([^">]+)"/', $this->content, $matches)) {
            return $matches[1]; // Ambil URL dari tag <img>
        }

        // Jika tidak ada gambar sama sekali, kembalikan gambar default
        return 'images/default.jpg';
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function creator()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_creator')
            ->wherePivot('is_creator', true);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'creation_likes')
            ->withTimestamps();
    }
}
