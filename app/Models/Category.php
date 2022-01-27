<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'thumbnail', 'description', 'parent_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeOnlyParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSearch($query, $title)
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class)->where('status', 'publish');
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function generation()
    {
        return $this->children()->with('generation');
    }

    public function root()
    {
        return $this->parent ? $this->parent->root() : $this;
    }
}
