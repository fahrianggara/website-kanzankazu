<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\WebSetting;
use App\Notifications\UserPostApproved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Add this custom validation rule.
        Validator::extend('alpha_spaces', function ($attribute, $value) {

            // This will only accept alpha and spaces.
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        //Add this custom validation rule.
        Validator::extend('url_www', function ($attribute, $value) {

            return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $value);
        });

        View::composer('*', function ($view) {
            $postUserApprove = Post::approve()->where('user_id', Auth::id())->latest();
            $view->with([
                'postUserApprove' => $postUserApprove->limit(3)->get(),
                'postApprove' => Post::approve()->limit(3)->get(),
                'setting' => WebSetting::find(1),
            ]);
        });
    }
}
