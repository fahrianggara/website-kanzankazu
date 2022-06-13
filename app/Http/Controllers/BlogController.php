<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\RecommendationPost;
use App\Models\Tag;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class BlogController extends Controller
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
        // Filtering archives by month and year
        $posts = Post::with('user')
            ->publish()
            ->latest()
            ->filter(request(['month', 'year']))
            ->paginate(6)
            ->appends(request(['month', 'year']));

        return view('blog.blog', [
            'posts' => $posts,
        ]);
    }

    public function blogDetail($slug)
    {
        $post = Post::publish()->with('categories', 'tags')->where('slug', $slug)->first();

        if (!$post) {
            return redirect()->route('blog.home')->with('success', 'Oops.. blog tidak ditemukan :(');
        }

        // next,prev button
        $next_id = Post::publish()
            ->with('categories', 'tags')
            ->where('id', '>', $post->id)
            ->min('id');
        $prev_id = Post::publish()
            ->with('categories', 'tags')
            ->where('id', '<', $post->id)
            ->max('id');

        // counting viewer when click post detail with session
        if (!(Session::get('slug') == $slug)) {
            Post::publish()->where('slug', $slug)->increment('views');
            session::put('slug', $slug);
        }

        // Related article by category
        $category_ids = [];
        foreach ($post->category as $category) {
            array_push($category_ids, $category->id);
        }
        $posts = Post::with('user')->publish()->where('id', '!=', $post->id)->whereHas('category', function ($q) use ($category_ids) {
            $q->whereIn('category_id', $category_ids);
        })->popular()->paginate(3);

        if (request()->ajax()) {
            return view('blog.sub-blog.related-post', compact('posts'));
        }

        return view('blog.blog-detail', [
            'post' => $post,
            'tags' => Tag::all(),
            'categories' => Category::onlyParent()->withCount('posts')->get(),
            'next' => Post::find($next_id),
            'prev' => Post::find($prev_id),
            'recents' => Post::publish()->latest()->limit(3)->get(),
            'posts' => $posts,
        ]);
    }

    public function showCategory()
    {
        return view('blog.categories', [
            'categories' => Category::onlyParent()->paginate(10),
        ]);
    }

    public function searchPosts(Request $request)
    {
        if (!$request->get('keyword')) {
            return redirect()->route('blog.home');
        }

        $q = $request->get('keyword');

        $posts = Post::publish()->where('title', 'LIKE', '%' . $q . '%')
            ->latest()
            ->paginate(10);

        return view('blog.search-blogs', [
            'posts' => $posts->appends(['keyword' => $request->keyword]),
        ]);
    }

    public function autoCompleteAjax(Request $request)
    {
        $search =  $request->term;

        $posts = Post::publish()->where('title', 'LIKE', "%{$search}%")
            ->latest()->limit(5)->get();

        if (!$posts->isEmpty()) {
            foreach ($posts as $post) {

                $new_row['title'] = $post->title;
                // $new_row['url'] = url('blog/' . $post->slug);
                $new_row['url'] = route('blog.detail', ['slug' => $post->slug]);

                $row_set[] = $new_row;
            }
        }

        echo json_encode($row_set);
    }

    public function showPostsByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::publish()->whereHas('categories', function ($query) use ($slug) {
            return $query->where('slug', $slug);
        })->latest()->paginate(10);

        $categoryRoot = $category->root();

        return view('blog.blog-category', [
            'posts' => $posts,
            'category' => $category,
            'categoryRoot' => $categoryRoot
        ]);
    }

    public function showPostsByTag($slug)
    {
        $posts = Post::publish()->whereHas('tags', function ($query) use ($slug) {
            return $query->where('slug', $slug);
        })->latest()->paginate(10);

        $tag = Tag::where('slug', $slug)->firstOrFail();

        $tags = Tag::search($tag->title)->get();

        // dd($posts);

        return view('blog.blog-tag', [
            'posts' => $posts,
            'tag'   => $tag,
            'tags' => $tags,
        ]);
    }

    public function showTags()
    {
        return view('blog.tags', [
            'tags' => Tag::paginate(20),
        ]);
    }

    public function showPostsByAuthor(User $author)
    {
        $user = $author;

        $posts = $author
            ->post()
            ->publish()
            ->latest()
            ->paginate(6);

        if ($author->slug == 'admin') {
            return redirect()->route('blog.authors')
                ->with('success', 'kamu tidak bisa mengakses halaman ini');
        } else if ($author->slug == 'mimin') {
            return redirect()->route('blog.authors')
                ->with('success', 'kamu tidak bisa mengakses halaman ini');
        } else if ($author->slug == 'editor') {
            return redirect()->route('blog.authors')
                ->with('success', 'kamu tidak bisa mengakses halaman ini');
        }

        $recommendationPosts = RecommendationPost::select('post_id')
            ->where('recommendation_posts.user_id', $author->id)
            ->join('posts', 'posts.id', '=', 'recommendation_posts.post_id')
            ->where('posts.status', 'publish')
            ->orderBy('recommendation_posts.post_id', 'desc')
            ->take(3)
            ->get();

        return view('blog.authors', compact(
            'posts',
            'recommendationPosts',
            'user',
        ));
    }

    public function showPostsbyMonthYear($year, $month)
    {
        $post = Post::publish();

        // Filtering archives by month and year
        $posts = Post::with('user')
            ->publish()
            ->latest()
            ->filter(request(['month', 'year']))
            ->paginate(10)
            ->appends(request(['month', 'year']));

        // Query
        $archives = Post::publish()
            ->selectRaw('year(created_at) year, monthname(created_at) month, count(*) publish')
            ->groupBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toArray();

        return view('blog.blog-year-month', compact('posts', 'archives', 'post'));
    }

    public function showAuthors()
    {
        $authors = User::where('name', '!=', 'Editor')
            ->where('name', '!=', 'Mimin')
            ->where('name', '!=', 'Admin')
            ->orderBy('created_at', 'desc')->paginate(12);

        return view('blog.blog-author', [
            'authors' => $authors,
        ]);
    }
}
