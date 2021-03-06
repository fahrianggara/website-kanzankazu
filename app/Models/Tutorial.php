<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'thumbnail', 'description', 'user_id', 'bg_color', 'text_color', 'keywords'];

    public function posts()
    {
        return $this->belongsToMany(Post::class)
            ->where('status', 'publish');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
