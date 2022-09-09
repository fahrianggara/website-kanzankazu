<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;
use App\Models\WebSetting;
use App\Notifications\UserPostApproved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function () {
            return realpath(base_path() . '/../../public_html/blog');
        });

        // $this->app->bind('path.public', function () {
        //     return realpath(base_path() . '/public');
        // });
    }

    /**
     * Bootstrap any applicati0on services.
     *
     * @return void
     */
    public function boot()
    {
        // if(config('app.env') === 'local') {
        //     URL::forceScheme('https');
        // }

        Carbon::setLocale('id');

        //Add this custom validation rule.
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        //Add this custom validation rule.
        Validator::extend('url_www', function ($attribute, $value) {
            return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $value);
        });

        View::composer('*', function ($view) {
            $authId = Auth::id();
            $postUserApprove = Post::approve()->where('user_id', $authId)->latest();
            // $currentRoute = Route::current();
            // $paramsBlogs = $currentRoute->parameters();

            $listsAdmin = User::select(
                'users.id',
                'users.name',
                'users.user_image',
                'users.last_seen',
                'users.uid',
                'users.email',
                DB::raw('count(is_read) as unread')
            )->with('messages')->whereHas('roles', function ($query) {
                $query->where('roles.name', 'mimin');
            })->leftJoin('messages', function ($join) use ($authId) {
                $join->on('users.id', '=', 'messages.user_id')->where('messages.is_read', 0)
                    ->where('receiver_id', $authId);
            })->groupBy(
                'users.id',
                'users.name',
                'users.user_image',
                'users.last_seen',
                'users.uid',
                'users.email',
            )
            ->orderBy('users.last_seen', 'DESC')
            ->limit(2)
            ->get();

            $view->with([
                'postUserApprove' => $postUserApprove->limit(3)->get(),
                'postApprove' => Post::approve()->limit(3)->get(),
                'setting' => WebSetting::find(1),
                'countInbox' => Contact::unanswered()->count(),
                'listsAdmin' => $listsAdmin
            ]);
        });
    }
}
