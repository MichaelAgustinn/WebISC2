<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

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

    protected $fillable = ['user_id', 'title', 'slug', 'content'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
