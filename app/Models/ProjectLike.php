<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLike extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'user_id'];

    /**
     * Relasi: Like ini milik satu Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relasi: Like ini dilakukan oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
