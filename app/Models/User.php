<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravelista\Comments\Comment;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Laravelista\Comments\Commenter;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Commenter, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_image',
        'slug',
        'email_verified_at',
        'remember_token',
        'fcm_token',
        'uid',
        'provider',
        'banned_at',
        'status',
        'pf_vision',
        'pf_mission',
        'pf_resume',
        'pf_skill_desc',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'roles'
    ];

    protected $appends = ['role_names'];

    protected $dates = [
        'email_verified_at',
        'banned_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public static function getUserById($id)
    {
        return User::where('id', $id)->first();
    }

    public static function checkUserPassword(User $user, Request $request)
    {
        return (!$user || !Hash::check($request->password, $user->password));
    }

    public static function createNewToken(User $user)
    {
        return $user->createToken('token', ['server:update'])->plainTextToken;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'commenter_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }
    public function messageReceiver()
    {
        $this->hasOne(Message::class, 'receiver_id')->latest();
    }
    public function messageSender()
    {
        $this->hasOne(Message::class, 'user_id')->latest();
    }
    public function post()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function todoList()
    {
        return $this->hasMany(TodoLists::class, 'user_id');
    }

    public function getRoleNamesAttribute()
    {
        return $this->belongsToMany(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->where('status', 'publish');
    }

    public function tutorials()
    {
        return $this->belongsToMany(Tutorial::class, 'post_tutorial')
            ->withTimestamps();
    }

    public function portofolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function portfolioSkills()
    {
        return $this->hasMany(PortfolioSkill::class, 'user_id');
    }

    public function titlePorts()
    {
        return $this->hasMany(Project::class);
    }

    public function titlePortfolio()
    {
        return $this->belongsToMany(Project::class, 'portfolio_project');
    }

    public function publish($query)
    {
        return $query->where('status', "publish");
    }

    public function recommendedPosts()
    {
        return $this->hasMany(RecommendationPost::class, 'user_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return asset('vendor/dashboard/image/picture-profiles/' . $value);
        } else {
            return asset('vendor/dashboard/image/picture-profiles/avatar.png');
        }
    }

    public function editorRole()
    {
        return $this->roles()->where('name', 'Editor')->first();
    }

    public function adminRole()
    {
        return $this->roles()->where('name', 'Admin')->first();
    }

    public function miminRole()
    {
        return $this->roles()->where('name', 'Mimin')->first();
    }

    public function scopeAllowable($query)
    {
        return $query->where('status', "allowable");
    }

    public function scopeBanned($query)
    {
        return $query->where('status', "banned");
    }

    public function scopeNotverify($query)
    {
        return $query->where('status', 'notverification');
    }

    public function scopeSearch($query, $data)
    {
        return $query->where('name', 'LIKE', "%{$data}%")
            ->orWhere('email', 'LIKE', "%{$data}%")
            ->orWhere('provider', 'LIKE', "%{$data}%");
    }
}
