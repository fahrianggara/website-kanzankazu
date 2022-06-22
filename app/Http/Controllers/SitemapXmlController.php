<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\App;

class SitemapXmlController extends Controller
{
    public function index()
    {
        $posts = Post::publish()->get();
        return response()->view('sitemap', compact('posts'))
        ->header('Content-Type', 'text/xml');
    }
}
