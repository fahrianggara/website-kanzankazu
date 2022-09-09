<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = "messages";

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'receiver_id',
        'message',
        'is_read'
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
