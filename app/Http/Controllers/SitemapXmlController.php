<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Tutorial;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Route;

class SitemapXmlController extends Controller
{

    public function post()
    {
        $posts = Post::publish()->get();

        return response()
            ->view('seo.sitemap.post-sitemap', compact('posts'))
            ->header('Content-Type', 'text/xml');
    }

    public function tutorial()
    {
        $tutorials = Tutorial::whereHas('posts', function ($query) {
            $query->publish();
        })->get();

        return response()
            ->view('seo.sitemap.tutorial-sitemap', compact('tutorials'))
            ->header('Content-Type', 'text/xml');
    }

    public function category()
    {
        $categories = Category::whereHas('posts', function ($query) {
            $query->publish();
        })->get();

        return response()
            ->view('seo.sitemap.category-sitemap', compact('categories'))
            ->header('Content-Type', 'text/xml');
    }

    public function tag()
    {
        $tags = Tag::whereHas('posts', function ($query) {
            $query->publish();
        })->get();

        return response()
            ->view('seo.sitemap.tag-sitemap', compact('tags'))
            ->header('Content-Type', 'text/xml');
    }

    public function user()
    {
        $users = User::whereHas('posts', function ($query) {
            $query->publish();
        })->get();

        return response()
            ->view('seo.sitemap.user-sitemap', compact('users'))
            ->header('Content-Type', 'text/xml');
    }

    public function sitemap()
    {
        return response()
            ->view('seo.sitemap.sitemap')
            ->header('Content-Type', 'text/xml');
    }

    public function feed()
    {
        $posts = Post::publish()->latest()->take(10)->get();
        return response()
            ->view('seo.rss.feed', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }
}
