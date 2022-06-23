<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Tutorial;
use App\Models\User;

class SitemapXmlController extends Controller
{
    public function index()
    {
        $posts = Post::publish()->get();
        $tutorials = Tutorial::whereHas('posts', function ($query) {
            $query->publish();
        })->get();
        $categories = Category::whereHas('posts', function ($query) {
            $query->publish();
        })->get();
        $tags = Tag::whereHas('posts', function ($query) {
            $query->publish();
        })->get();
        $users = User::whereHas('posts', function ($query) {
            $query->publish();
        })->get();

        return response()
            ->view('sitemap', compact('posts', 'tutorials', 'categories', 'tags', 'users'))
            ->header('Content-Type', 'text/xml');
    }
}
