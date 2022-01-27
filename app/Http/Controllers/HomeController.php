<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::publish()->latest()->limit(3)->get();

        return view('layouts.home', [
            'posts' => $posts,
        ]);
    }
}
