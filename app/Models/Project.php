<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'image', 'division'];

    // Relasi ke Anggota Tim (Many to Many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function likes()
    {
        return $this->hasMany(ProjectLike::class);
    }

    // Helper: Cek apakah project ini sudah dilike oleh user tertentu
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
