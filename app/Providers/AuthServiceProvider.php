<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerPolicies();

        // MANAGE POST
        Gate::define('manage_posts', function ($user) {
            return $user->hasAnyPermission([
                'post_show',
                'post_create',
                'post_update',
                'post_detail',
                'post_delete',
                'post_approve',
            ]);
        });

        // MANAGE CATEGORY
        Gate::define('manage_categories', function ($user) {
            return $user->hasAnyPermission([
                'category_show',
                'category_create',
                'category_update',
                'category_detail',
                'category_delete'
            ]);
        });

        // MANAGE TAG
        Gate::define('manage_tags', function ($user) {
            return $user->hasAnyPermission([
                'tag_show',
                'tag_create',
                'tag_update',
                'tag_delete'
            ]);
        });

        // MANAGE ROLE
        Gate::define('manage_roles', function ($user) {
            return $user->hasAnyPermission([
                'role_show',
                'role_create',
                'role_update',
                'role_detail',
                'role_delete'
            ]);
        });

        // MANAGE USER
        Gate::define('manage_users', function ($user) {
            return $user->hasAnyPermission([
                'user_show',
                'user_create',
                'user_update',
                'user_delete'
            ]);
        });

        // MANAGE USER
        Gate::define('manage_inbox', function ($user) {
            return $user->hasAnyPermission([
                'inbox_show',
                'inbox_delete'
            ]);
        });

        // MANAGE WEBSITE
        Gate::define('manage_website', function ($user) {
            return $user->hasAnyPermission([
                'website_show',
                'website_update',
            ]);
        });
    }
}
