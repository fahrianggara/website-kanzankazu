<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tutorial;
use App\Models\WebSetting;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $setting = WebSetting::find(1);
        View::share('setting', $setting);

        $footerPost = Post::publish()
            ->popular()
            ->take(3)
            ->get();
        View::share('footerPost', $footerPost);
    }

    public function index()
    {
        return view('layouts.home', [
            'posts' => Post::publish()->latest()->limit(3)->get(),
            'categories' =>  Category::onlyParent()
                ->whereHas('posts', function ($query) {
                    $query->publish();
                })->latest()->limit(3)->get(),
            'tutorials' => Tutorial::whereHas('posts', function ($query) {
                $query->publish();
            })->latest()->limit(3)->get(),
        ]);
    }
}
