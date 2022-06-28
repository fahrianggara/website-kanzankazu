<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'keywords'];
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeSearch($query, $title)
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class)->where('status', 'publish');
    }
}
