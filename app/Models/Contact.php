<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = "contact";
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function scopeSearch($query, $name)
    {
        return $query->where('name', 'LIKE', "%{$name}%");
    }
}
