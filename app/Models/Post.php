<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravelista\Comments\Comment;
use Laravelista\Comments\Commentable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory, Commentable;
    protected $table = "posts";
    protected $fillable = ['title', 'slug', 'author', 'thumbnail', 'description', 'content', 'keywords', 'status', 'user_id', 'views', 'deleted_at', 'tutorial_id'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function recommendedPost()
    {
        return $this->hasOne(RecommendationPost::class, 'post_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function tutorials()
    {
        return $this->belongsToMany(Tutorial::class)
            ->withTimestamps();
    }

    public function tutorial()
    {
        return $this->belongsToMany(Tutorial::class, 'post_tutorial');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select(
            'id',
            'name',
            'slug',
            'user_image',
            'bio',
            'facebook',
            'twitter',
            'instagram',
            'github'
        );
    }

    public function scopeSearch($query, $title)
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }

    public function scopePublish($query)
    {
        return $query->where('status', "publish");
    }

    public function scopeDraft($query)
    {
        return $query->where('status', "draft");
    }

    public function scopeApprove($query)
    {
        return $query->where('status', "approve");
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'DESC');
    }

    public function scopeUserWithApprove($query)
    {
        return $query->where('status', "approve")->where('user_id', Auth::id());
    }

    public function scopeFilter($query, $filters)
    {
        if ($month = request('month')) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }

        if ($year = request('year')) {
            $query->whereYear('created_at', $year);
        }
    }
}
