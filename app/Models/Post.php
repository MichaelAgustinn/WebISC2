<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'description', 'thumbnail'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }
    // Relasi ke Pembuat Post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Komentar
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
