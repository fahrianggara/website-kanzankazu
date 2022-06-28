<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Newsletter;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Tutorial;
use App\Models\WebSetting;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:website_show', ['only' => 'index']);
        $this->middleware('permission:website_update', ['only' => ['update']]);
    }

    public function dashboard()
    {
        $countUser = User::count();
        $countPost = Post::publish()
            ->where('user_id', Auth::id())
            ->count();
        $countTag = Tag::count();
        $countCategory = Category::count();
        $countContact = Contact::count();
        $countRole = Role::count();
        $countTutorial = Tutorial::count();
        $countNewsletter = Newsletter::count();

        // post today
        $Today = Carbon::today();
        $postToday = Post::publish()
            ->whereDate('created_at', $Today)
            ->paginate(4);
        $cateToday = Category::select('title', 'thumbnail', 'description')
            ->whereDate('created_at', $Today)
            ->paginate(4);
        $tutorToday = Tutorial::select('title', 'thumbnail', 'description')
            ->whereDate('created_at', $Today)
            ->paginate(4);
        $tagToday = Tag::select('title')
            ->whereDate('created_at', $Today)
            ->get();
        $inboxToday = Contact::select('name', 'email', 'subject', 'message')
            ->whereDate('created_at', $Today)
            ->get();
        $newsletterToday = Newsletter::whereDate('created_at', $Today)
            ->get();
        $userToday = User::whereDate('created_at', $Today)
            ->paginate(3);
        $roleToday = Role::select('name')
            ->whereDate('created_at', $Today)
            ->get();

        return view('dashboard.index', compact(
            'countUser',
            'countPost',
            'countTag',
            'countCategory',
            'countContact',
            'countRole',
            'countTutorial',
            'countNewsletter',
            'postToday',
            'cateToday',
            'tagToday',
            'inboxToday',
            'userToday',
            'roleToday',
            'tutorToday',
            'newsletterToday'
        ));
    }
}
