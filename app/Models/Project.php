<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'user_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function portfolios()
    {
        return $this->belongsToMany(Portfolio::class);
    }

    public function search($query, $title)
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }
}
