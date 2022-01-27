<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\Tag;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $countUser = User::count();
        $countPost = Post::count();
        $countTag = Tag::count();
        $countCategory = Category::count();
        $countContact = Contact::count();
        $countRole = Role::count();

        return view('dashboard.index', [
            'countUser' => $countUser,
            'countPost' => $countPost,
            'countCategory' => $countCategory,
            'countTag' => $countTag,
            'countContact' => $countContact,
            'countRole' => $countRole,
        ]);
    }
}
