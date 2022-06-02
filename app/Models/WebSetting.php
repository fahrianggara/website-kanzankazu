<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name',
        'site_description',
        'site_footer',
        'site_email',
        'site_twitter',
        'site_github',
        'meta_keywords',
        'image_banner',
    ];
}
