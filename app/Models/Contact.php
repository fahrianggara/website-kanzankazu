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
        'message',
        'status',
        'answerer',
        'replay_subject',
        'replay_message',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function scopeSearch($query, $inbox)
    {
        return $query->where('subject', 'LIKE', "%{$inbox}%")
            ->orWhere('name', 'LIKE', "%{$inbox}%");
    }

    public function scopeUnanswered($query)
    {
        return $query->where('status', 'unanswered');
    }

    public function scopeAnswered($query)
    {
        return $query->where('status', 'answered');
    }
}
