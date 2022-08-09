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
    // public function index()
    // {
    //     $posts = Post::publish()->get();
    //     $tutorials = Tutorial::whereHas('posts', function ($query) {
    //         $query->publish();
    //     })->get();
    //     $categories = Category::whereHas('posts', function ($query) {
    //         $query->publish();
    //     })->get();
    //     $tags = Tag::whereHas('posts', function ($query) {
    //         $query->publish();
    //     })->get();
    //     $users = User::whereHas('posts', function ($query) {
    //         $query->publish();
    //     })->get();

    //     return response()
    //         ->view('sitemap', compact('posts', 'tutorials', 'categories', 'tags', 'users'))
    //         ->header('Content-Type', 'text/xml');
    // }

    public function post()
    {
        $posts = Post::publish()->get();
        $sitemap = Sitemap::create();
        foreach ($posts as $post) {
            $sitemap->add(Url::create($post->slug)
                ->setLastModificationDate(Carbon::create($post->updated_at))
                ->addImage($post->thumbnail, $post->title));
        }
        return $sitemap->writeToFile('post-sitemap.xml');
    }

    public function tutorial()
    {
        $tutorials = Tutorial::whereHas('posts', function ($query) {
            $query->publish();
        })->get();
        $sitemap = Sitemap::create();
        foreach ($tutorials as $tutorial) {
            $sitemap->add(Url::create($tutorial->slug)
                ->addImage($tutorial->thumbnail, $tutorial->title));
        }
        return $sitemap->writeToFile('tutorial-sitemap.xml');
    }

    public function category()
    {
        $categories = Category::whereHas('posts', function ($query) {
            $query->publish();
        })->get();
        $sitemap = Sitemap::create();
        foreach ($categories as $category) {
            $sitemap->add(Url::create($category->slug)
                ->addImage($category->thumbnail, $category->title));
        }
        return $sitemap->writeToFile('category-sitemap.xml');
    }

    public function tag()
    {
        $tags = Tag::whereHas('posts', function ($query) {
            $query->publish();
        })->get();
        $sitemap = Sitemap::create();
        foreach ($tags as $tag) {
            $sitemap->add($tag->slug);
        }
        return $sitemap->writeToFile('tag-sitemap.xml');
    }

    public function user()
    {
        $users = User::whereHas('posts', function ($query) {
            $query->publish();
        })->get();
        $sitemap = Sitemap::create();
        foreach ($users as $user) {
            $sitemap->add(Url::create(route('blog.author', $user->slug))->addImage($user->user_image, $user->name));
        }
        return $sitemap->writeToFile('user-sitemap.xml');
    }

    public function sitemap()
    {
        $sitemap = Sitemap::create();
        $sitemap->add(Url::create(route('homepage'))->setPriority(1))
            ->add(Url::create(route('blog.home'))->setPriority(0.9))
            ->add(Url::create(route('blog.categories'))->setPriority(0.9))
            ->add(Url::create(route('blog.tags'))->setPriority(0.9))
            ->add(Url::create(route('blog.tutorials'))->setPriority(0.9))
            ->add(Url::create(route('blog.categories'))->setPriority(0.9))
            ->add(Url::create(route('blog.authors'))->setPriority(0.9))
            ->add(Url::create(route('blog.search'))->setPriority(0.9))
            ->add(Url::create(route('login'))->setPriority(0.9))
            ->add(Url::create(route('register'))->setPriority(0.9));

        return $sitemap->writeToFile('sitemap.xml');
    }

    public function feed()
    {
        $posts = Post::publish()->latest()->take(10)->get();
        return response()
            ->view('seo.rss.feed', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }
}
