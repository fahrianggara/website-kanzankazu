<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'thumbnail', 'description'];

    public function posts()
    {
        return $this->belongsToMany(Post::class)->where('status', 'publish');
    }
}
