<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        return view('layouts.home', [
            'posts' => Post::publish()->latest()->limit(3)->get(),
            'categories' =>  Category::onlyParent()->latest()->limit(3)->get(),
        ]);
    }
}
