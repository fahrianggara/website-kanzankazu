<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Post;
use App\Models\WebSetting;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware([
        //     'auth',
        //     'verified'
        // ]);

        $setting = WebSetting::find(1);

        $footerPost = Post::publish()
            ->popular()
            ->take(3)
            ->get();

        $postIndex = Post::with('user')
            ->publish()
            ->latest()
            ->filter(request(['month', 'year']))
            ->paginate(10)
            ->appends(request(['month', 'year']));

        $archiveBlogs = Post::publish()
            ->selectRaw('year(created_at) year, monthname(created_at) month, count(*) publish')
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toArray();

        View::share('footerPost', $footerPost);
        View::share('postIndex', $postIndex);
        View::share('archiveBlogs', $archiveBlogs);
        View::share('setting', $setting);
    }
}
