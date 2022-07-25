<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoLists extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'completed', 'completed_at', 'sort'];
    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
