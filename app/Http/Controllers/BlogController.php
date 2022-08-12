<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Dashboard\ProjectPortfolioController;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Portfolio;
use App\Models\PortfolioSkill;
use App\Models\Project;
use App\Models\RecommendationPost;
use App\Models\Tag;
use App\Models\Tutorial;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
// OR with multi
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View as ViewView;

class BlogController extends Controller
{

    public function index()
    {
        $setting = WebSetting::find(1);

        SEOTools::setTitle('Blog - ' . $setting->site_name);
        SEOTools::setDescription($setting->site_description);
        SEOTools::opengraph()->setUrl(route('blog.home'));
        SEOTools::setCanonical(route('blog.home'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@' . $setting->site_name);
        SEOTools::jsonLd()->addImage(asset('vendor/blog/img/default.png'));

        // Filtering archives by month and year
        $posts = Post::with('user')
            ->publish()
            ->latest()
            ->paginate(6);

        return view('blog.blog', [
            'posts' => $posts,
        ]);
    }

    public function blogDetail($slug)
    {
        $post = Post::publish()->with('categories', 'tags')->where('slug', $slug)->first();

        if (!$post) {
            return redirect()->route('blog.home');
        }

        $setting = WebSetting::find(1);

        SEOMeta::setTitle($post->title . ' - ' . $setting->site_name);
        SEOMeta::setDescription($post->description);
        SEOMeta::addMeta('article:published_time', Carbon::parse($post->created_at)->toW3cString() . PHP_EOL, 'property');
        SEOMeta::addMeta('article:section', $post->categories->pluck('title')->first(), 'property');
        SEOMeta::addKeyword($post->title . ' ' . $setting->site_name);

        OpenGraph::setDescription($post->description);
        OpenGraph::setTitle($post->title . ' - ' . $setting->site_name);
        OpenGraph::setUrl(route('blog.detail', $post->slug));
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-id');
        OpenGraph::addProperty('locale:alternate', ['id-id', 'en-us']);

        TwitterCard::setTitle($post->title . ' - ' . $setting->site_name);
        TwitterCard::setSite('@' . $post->user->name);

        JsonLd::setTitle($post->title);
        JsonLd::setDescription($post->description);
        JsonLd::setType('Article');

        JsonLdMulti::setTitle($post->title);
        JsonLdMulti::setDescription($post->description);
        JsonLdMulti::setType('Article');

        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle($post->title);
        }

        OpenGraph::setTitle($post->title)
            ->setUrl(route('blog.detail', $post->slug))
            ->setSiteName($setting->site_name)
            ->setDescription($post->description)
            ->setType('article')
            ->setArticle([
                'published_time' => Carbon::parse($post->created_at)->toW3cString() . PHP_EOL,
                'modified_time' => Carbon::parse($post->updated_at)->toW3cString() . PHP_EOL,
                'author' => $post->user->name,
                'tag' => $post->tags->pluck('title')->toArray(),
                'section' => $post->categories->pluck('title')->first(),
            ]);

        if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail)) {
            OpenGraph::addImage(asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail));
            OpenGraph::addImage(['url' => asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail), 'size' => 800]);
            OpenGraph::addImage(asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail), ['height' => 800, 'width' => 1280]);
            JsonLd::addImage(asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail));
            JsonLdMulti::addImage(asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail));
        } else {
            OpenGraph::addImage(asset('vendor/blog/img/default.png'));
            OpenGraph::addImage(['url' => asset('vendor/blog/img/default.png'), 'size' => 800]);
            OpenGraph::addImage(asset('vendor/blog/img/default.png'), ['height' => 800, 'width' => 1280]);
            JsonLd::addImage(asset('vendor/blog/img/default.png'));
            JsonLdMulti::addImage(asset('vendor/blog/img/default.png'));
        }

        // next,prev button
        $next_id = Post::publish()
            ->where('id', '>', $post->id)
            ->min('id');
        $prev_id = Post::publish()
            ->where('id', '<', $post->id)
            ->max('id');

        // counting viewer when click post detail with session
        if (!(Session::get('slug') == $slug)) {
            Post::publish()->where('slug', $slug)->increment('views');
            session::put('slug', $slug);
        }

        // Related articles by tutorial
        $tutorial_ids = [];
        foreach ($post->tutorials as $tutorial) {
            array_push($tutorial_ids, $tutorial->id);
        }
        $tutoPosts = Post::publish()
            ->whereHas('tutorial', function ($query) use ($tutorial_ids) {
                $query->whereIn('tutorial_id', $tutorial_ids);
            })->whereHas('user', function ($query) use ($post) {
                $query->where('id', $post->user->id);
            })->orderBy('created_at', 'asc')->get();

        // Related article by category
        $category_ids = [];
        foreach ($post->category as $category) {
            array_push($category_ids, $category->id);
        }
        $posts = Post::with('user')->publish()
            ->where('id', '!=', $post->id)
            ->whereHas('category', function ($q) use ($category_ids) {
                $q->whereIn('category_id', $category_ids);
            })->whereHas('user', function ($query) use ($post) {
                $query->where('id', $post->user->id);
            })->popular()->paginate(3);

        if (request()->ajax()) {
            return view('blog.sub-blog.related-post', compact('posts'));
        }

        return view('blog.blog-detail', [
            'post' => $post,
            'tags' => Tag::whereHas('posts', function ($query) use ($post) {
                $query->publish();
            })->get(),
            'tutorials' => Tutorial::whereHas('posts', function ($query) {
                $query->publish();
            })->get(),
            'categories' => Category::onlyParent()->whereHas('posts', function ($query) {
                $query->publish();
            })->get(),
            'next' => Post::find($next_id),
            'prev' => Post::find($prev_id),
            'recents' => Post::publish()->latest()->limit(3)->get(),
            'posts' => $posts,
            'tutoPosts' => $tutoPosts,
        ]);
    }

    public function searchPosts(Request $request)
    {
        $q = $request->keyword;
        if (!$q) {
            return redirect()->route('blog.home');
        }

        $setting = WebSetting::find(1);
        SEOTools::setTitle($q . ' - ' . $setting->site_name);
        SEOTools::setDescription('Pencarian blog dengan kata kunci ' . $q);
        SEOTools::opengraph()->setUrl(route('blog.search', $q));
        SEOTools::setCanonical(route('blog.search', $q));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@' . $setting->site_name);
        SEOTools::jsonLd();

        $posts = Post::publish()->where('title', 'LIKE', '%' . $q . '%')
            ->latest()
            ->paginate(10);

        return view('blog.sub-blog.search-blogs', [
            'posts' => $posts->appends(['keyword' => $request->keyword]),
        ]);
    }

    public function autoCompleteAjax(Request $request)
    {
        $search =  $request->term;

        $posts = Post::publish()->where('title', 'LIKE', "%{$search}%")
            ->popular()->limit(9)->get();

        if (!$posts->isEmpty()) {
            foreach ($posts as $post) {

                if (strlen($post->title) > 25) {
                    $title = substr($post->title, 0, 25) . '...';
                } else {
                    $title = $post->title;
                }

                $new_row['title'] = $title;
                $new_row['url'] = route('blog.detail', ['slug' => $post->slug]);

                // if title same as search term, then remove it from the results
                if (strtolower($new_row['title']) == strtolower($search)) {
                    continue;
                }

                $row_set[] = $new_row;
            }
        }

        echo json_encode($row_set);
    }

    public function showCategory()
    {
        $setting = WebSetting::find(1);
        SEOTools::setTitle('Kategori - ' . $setting->site_name);
        SEOTools::setDescription('Seputar kategori teknologi di ' . $setting->site_name);
        SEOTools::opengraph()->setUrl(route('blog.categories'));
        SEOTools::setCanonical(route('blog.categories'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@' . $setting->site_name);
        SEOTools::jsonLd();

        return view('blog.categories.categories', [
            'categories' => Category::onlyParent()
                ->whereHas('posts', function ($query) {
                    $query->publish();
                })
                ->paginate(10),
        ]);
    }

    public function showPostsByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::publish()->whereHas('categories', function ($query) use ($slug) {
            return $query->where('slug', $slug);
        })->latest()->paginate(9);

        $categoryRoot = $category->root();

        $setting = WebSetting::find(1);

        SEOMeta::setTitle($category->title . ' - ' . $setting->site_name);
        SEOMeta::setDescription($category->description ?? 'Postingan kategori ' . $category->title . ' di ', $setting->site_name);
        SEOMeta::addMeta('article:published_time', Carbon::parse($category->created_at)->toW3cString() . PHP_EOL, 'property');
        SEOMeta::addKeyword([$category->title . ' ' . $setting->site_name]);

        OpenGraph::setDescription($category->description ?? 'Postingan kategori ' . $category->title . ' di ', $setting->site_name);
        OpenGraph::setTitle($category->title . ' - ' . $setting->site_name);
        OpenGraph::setUrl(route('blog.posts.categories', $category->slug));
        OpenGraph::addProperty('type', 'article');

        TwitterCard::setTitle($category->title . ' - ' . $setting->site_name);
        TwitterCard::setSite('@' . $setting->site_name);

        JsonLd::setTitle($category->title);
        JsonLd::setDescription($category->description ?? 'Postingan kategori ' . $category->title . ' di ', $setting->site_name);
        JsonLd::setType('Article');

        JsonLdMulti::setTitle($category->title);
        JsonLdMulti::setDescription($category->description ?? 'Postingan kategori ' . $category->title . ' di ', $setting->site_name);
        JsonLdMulti::setType('Article');

        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle($category->title);
        }

        OpenGraph::setTitle($category->title)
            ->setUrl(route('blog.posts.categories', $category->slug))
            ->setSiteName($setting->site_name)
            ->setDescription($category->description ?? 'Postingan kategori ' . $category->title . ' di ', $setting->site_name)
            ->setType('article')
            ->setArticle([
                'published_time' => Carbon::parse($category->created_at)->toW3cString() . PHP_EOL,
                'modified_time' => Carbon::parse($category->updated_at)->toW3cString() . PHP_EOL,
                'author' => $setting->site_name,
                'section' => $category->title,
            ]);

        if (file_exists('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail)) {
            OpenGraph::addImage(asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail));
            OpenGraph::addImage(['url' => asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail), 'size' => 800]);
            OpenGraph::addImage(asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail), ['height' => 800, 'width' => 1280]);
            JsonLdMulti::addImage(asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail));
            JsonLdMulti::addImage(asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail));
        } else {
            OpenGraph::addImage(asset('vendor/blog/img/default.png'));
            OpenGraph::addImage(['url' => asset('vendor/blog/img/default.png'), 'size' => 800]);
            OpenGraph::addImage(asset('vendor/blog/img/default.png'), ['height' => 800, 'width' => 1280]);
            JsonLdMulti::addImage(asset('vendor/blog/img/default.png'));
            JsonLdMulti::addImage(asset('vendor/blog/img/default.png'));
        }


        return view('blog.categories.blog-category', [
            'posts' => $posts,
            'category' => $category,
            'categoryRoot' => $categoryRoot
        ]);
    }

    public function showTags()
    {
        $setting = WebSetting::find(1);

        SEOTools::setTitle('Tag - ' . $setting->site_name);
        SEOTools::setDescription('Tag postingan di ' . $setting->site_name);
        SEOTools::opengraph()->setUrl(route('blog.tags'));
        SEOTools::setCanonical(route('blog.tags'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@' . $setting->site_name);
        SEOTools::jsonLd();

        return view('blog.tags.tags', [
            'tags' => Tag::whereHas('posts', function ($query) {
                $query->publish();
            })->paginate(20),
        ]);
    }

    public function showPostsByTag($slug)
    {
        $posts = Post::publish()->whereHas('tags', function ($query) use ($slug) {
            return $query->where('slug', $slug);
        })->latest()->paginate(10);

        $tag = Tag::where('slug', $slug)->firstOrFail();

        $setting = WebSetting::find(1);
        SEOMeta::setTitle($tag->title . ' - ' . $setting->site_name);
        SEOMeta::setDescription('Postingan Tag ' . $tag->title . ' di ' . $setting->site_name);
        SEOMeta::addMeta('article:published_time', Carbon::parse($tag->created_at)->toW3cString() . PHP_EOL, 'property');
        SEOMeta::addKeyword([$tag->title . ' ' . $setting->site_name]);

        OpenGraph::setTitle($tag->title . ' - ' . $setting->site_name);
        OpenGraph::setUrl(route('blog.posts.tags', $tag->slug));
        OpenGraph::addProperty('type', 'article');

        TwitterCard::setTitle($tag->title . ' - ' . $setting->site_name);
        TwitterCard::setSite('@' . $setting->site_name);

        JsonLd::setTitle($tag->title);
        JsonLd::setType('Article');
        JsonLd::setDescription('Postingan Tag ' . $tag->title . ' di ' . $setting->site_name);

        JsonLdMulti::setTitle($tag->title);
        JsonLdMulti::setDescription('Postingan Tag ' . $tag->title . ' di ' . $setting->site_name);
        JsonLdMulti::setType('Article');
        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle($tag->title);
        }

        OpenGraph::setTitle($tag->title . ' - ' . $setting->site_name)
            ->setUrl(route('blog.posts.tags', $tag->slug))
            ->setSiteName($setting->site_name)
            ->setType('article')
            ->setDescription('Postingan Tag ' . $tag->title . ' di ' . $setting->site_name)
            ->setArticle([
                'published_time' => Carbon::parse($tag->created_at)->toW3cString() . PHP_EOL,
                'modified_time' => Carbon::parse($tag->updated_at)->toW3cString() . PHP_EOL,
                'author' => $setting->site_name,
                'tag' => $tag->title,
            ]);

        return view('blog.tags.blog-tag', [
            'posts' => $posts,
            'tag'   => $tag,
            'tags' => Tag::search($tag->title)->get(),
        ]);
    }

    public function showAuthors()
    {
        $authors = User::allowable()->with(['posts' => fn ($query) => $query->where('status', 'publish')])
            ->whereHas('posts', fn ($query) => $query->where('status', 'publish'))
            ->where('name', '!=', 'Editor')
            ->where('name', '!=', 'Mimin')
            ->where('name', '!=', 'Admin')
            ->orderBy('created_at', 'desc')->paginate(12);

        $setting = WebSetting::find(1);

        SEOTools::setTitle('Author - ' . $setting->site_name);
        SEOTools::setDescription('Ini dia pembuat artikel di ' . $setting->site_name);
        SEOTools::opengraph()->setUrl(route('blog.authors'));
        SEOTools::setCanonical(route('blog.authors'));
        SEOTools::opengraph()->addProperty('type', 'profiles');
        SEOTools::twitter()->setSite('@' . $setting->site_name);
        SEOTools::jsonLd();

        return view('blog.authors.blog-author', [
            'authors' => $authors,
        ]);
    }

    public function showPostsByAuthor(User $author)
    {
        $user = $author;

        if ($author->status == 'banned') {
            return redirect()->back()->with('success', 'Author ini telah di banned');
        }

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

        $skills = PortfolioSkill::where('user_id', $author->id)->get();

        $recommendationPosts = RecommendationPost::select('post_id')
            ->where('recommendation_posts.user_id', $author->id)
            ->join('posts', 'posts.id', '=', 'recommendation_posts.post_id')
            ->where('posts.status', 'publish')
            ->orderBy('recommendation_posts.post_id', 'desc')
            ->take(3)
            ->get();

        $titleProject_ids = [];
        foreach ($author->titlePortfolio as $data) {
            array_push($titleProject_ids, $data->id);
        }
        $titleProjects = Project::whereIn('id', $titleProject_ids)->select('id', 'title')->get();

        $setting = WebSetting::find(1);

        SEOMeta::setTitle($user->name . ' - ' . $setting->site_name);
        SEOMeta::setDescription($user->bio ?? 'Hai aku ' . $user->name . ', si pembuat artikel di ' . $setting->site_name);
        SEOMeta::addMeta('profile:joined_time', Carbon::parse($user->created_at)->toW3cString() . PHP_EOL, 'property');
        SEOMeta::addKeyword([$user->name . ' ' . $setting->site_name]);

        OpenGraph::setDescription($user->bio ?? 'Hai aku ' . $user->name . ', si pembuat artikel di ' . $setting->site_name);
        OpenGraph::setTitle($user->name . ' - ' . $setting->site_name);
        OpenGraph::setUrl(route('blog.author', $user->slug));
        OpenGraph::addProperty('type', 'profile');

        TwitterCard::setTitle($user->name . ' - ' . $setting->site_name);
        TwitterCard::setSite('@' . $user->name);

        JsonLd::setTitle($user->name);
        JsonLd::setDescription($user->bio ?? 'Hai aku ' . $user->name . ', si pembuat artikel di ' . $setting->site_name);
        JsonLd::setType('Profile');

        JsonLdMulti::setTitle($user->name);
        JsonLdMulti::setDescription($user->bio ?? 'Hai aku ' . $user->name . ', si pembuat artikel di ' . $setting->site_name);
        JsonLdMulti::setType('Profile');

        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle($user->name);
        }

        OpenGraph::setTitle($user->name . ' - ' . $setting->site_name)
            ->setDescription($user->bio ?? 'Hai aku ' . $user->name . ', si pembuat artikel di ' . $setting->site_name)
            ->setUrl(route('blog.author', $user->slug))
            ->setType('profile')
            ->setProfile([
                'first_name' => $user->name,
                'username' => $user->slug,
            ]);

        if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image)) {
            OpenGraph::addImage(['url' => asset('vendor/dashboard/image/picture-profiles/' . $user->user_image), 'size' => 1080]);
            OpenGraph::addImage(asset('vendor/dashboard/image/picture-profiles/' . $user->user_image), ['height' => 1080, 'width' => 1080]);
            JsonLd::addImage(asset('vendor/dashboard/image/picture-profiles/' . $user->user_image));
            JsonLdMulti::addImage(asset('vendor/dashboard/image/picture-profiles/' . $user->user_image));
        } else {
            OpenGraph::addImage(['url' => asset('vendor/dashboard/image/avatar.png'), 'size' => 1080]);
            OpenGraph::addImage(asset('vendor/dashboard/image/avatar.png'), ['height' => 1080, 'width' => 1080]);
            JsonLd::addImage(asset('vendor/dashboard/image/avatar.png'));
            JsonLdMulti::addImage(asset('vendor/dashboard/image/avatar.png'));
        }

        return view('blog.authors.authors', compact(
            'posts',
            'recommendationPosts',
            'user',
            'titleProjects',
            'skills'
        ));
    }

    public function showTutorial()
    {
        $setting = WebSetting::find(1);

        SEOTools::setTitle('Tutorial - ' . $setting->site_name);
        SEOTools::setDescription('Seputar tutorial teknologi di ' . $setting->site_name);
        SEOTools::opengraph()->setUrl(route('blog.tutorials'));
        SEOTools::setCanonical(route('blog.tutorials'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite('@' . $setting->site_name);
        SEOTools::jsonLd();

        return view('blog.tutorials.tutorials', [
            'tutorials' => Tutorial::whereHas('posts', function ($q) {
                $q->publish();
            })->paginate(10),
        ]);
    }

    public function showPostsByTutorial($slug)
    {
        $tutorial = Tutorial::where('slug', $slug)->first();

        $users = User::allowable()->with(['posts' => fn ($query) => $query->where('status', 'publish')])
            ->whereHas('posts', fn ($query) => $query->where('posts.status', 'publish')
                ->where('tutorial_id', $tutorial->id))
            ->with(['tutorials' => fn ($query) => $query->where('tutorials.slug', $slug)])
            ->whereHas('tutorials', fn ($query) => $query->where('tutorials.slug', $slug))
            ->get();

        $setting = WebSetting::find(1);

        SEOTools::setTitle($tutorial->title . ' - ' . $setting->site_name);
        SEOTools::setDescription('Tutorial ' . $tutorial->title . ' di ' . $setting->site_name);
        SEOTools::opengraph()->setUrl(route('blog.posts.tutorials', $tutorial->slug));
        SEOTools::setCanonical(route('blog.posts.tutorials', $tutorial->slug));
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::twitter()->setSite('@' . $setting->site_name);
        SEOTools::jsonLd();

        return view('blog.tutorials.blog-tutorial', [
            'users' => $users,
            'tutorial' => $tutorial,
        ]);
    }

    public function showPostsByTutorialByAuthor($slug, $user)
    {
        $author = User::allowable()->where('slug', $user)->first();

        $tutorial = Tutorial::with(['posts' => function ($q) use ($author) {
            return $q->whereHas('user', function ($q) use ($author) {
                return $q->where('slug', $author->slug);
            });
        }])->where('slug', $slug)->first();

        $posts = Post::publish()->whereHas('tutorials', function ($query) use ($slug) {
            return $query->where('slug', $slug);
        })->whereHas('user', function ($query) use ($user) {
            return $query->where('slug', $user);
        })->orderBy('id', 'asc')->get();

        $setting = WebSetting::find(1);

        SEOMeta::setTitle('Tutorial ' . $tutorial->title . ' by ' . $author->name . ' - ' . $setting->site_name);
        SEOMeta::setDescription($tutorial->description ?? 'Tutorial ' . $tutorial->title . ' di ' . $setting->site_name);
        SEOMeta::addMeta('author', $author->name);
        SEOMeta::addMeta('article:published_time', Carbon::parse($tutorial->created_at)->toW3cString() . PHP_EOL, 'property');
        SEOMeta::addKeyword([$tutorial->title . ' ' . $setting->site_name]);

        OpenGraph::setDescription($tutorial->description ?? 'Tutorial ' . $tutorial->title . ' di ' . $setting->site_name);
        OpenGraph::setTitle('Tutorial ' . $tutorial->title . ' by ' . $author->name . ' - ' . $setting->site_name);
        OpenGraph::setUrl(route('blog.posts.tutorials.author', ['slug' => $tutorial->slug, 'user' => $author->slug]));
        OpenGraph::addProperty('type', 'article');

        TwitterCard::setTitle('Tutorial ' . $tutorial->title . ' by ' . $author->name . ' - ' . $setting->site_name);
        TwitterCard::setSite('@' . $setting->site_name);

        JsonLd::setTitle($tutorial->title);
        JsonLd::setDescription($tutorial->description ?? 'Tutorial ' . $tutorial->title . ' di ' . $setting->site_name);
        JsonLd::setType('Article');

        JsonLdMulti::setTitle($tutorial->title);
        JsonLdMulti::setDescription($tutorial->description ?? 'Tutorial ' . $tutorial->title . ' di ' . $setting->site_name);
        JsonLdMulti::setType('Article');

        if (!JsonLdMulti::isEmpty()) {
            JsonLdMulti::newJsonLd();
            JsonLdMulti::setType('WebPage');
            JsonLdMulti::setTitle($tutorial->title);
        }

        OpenGraph::setTitle('Tutorial ' . $tutorial->title . ' by ' . $author->name . ' - ' . $setting->site_name)
            ->setUrl(route('blog.posts.tutorials.author', ['slug' => $tutorial->slug, 'user' => $author->slug]))
            ->setSiteName($setting->site_name)
            ->setDescription($tutorial->description ?? 'Tutorial ' . $tutorial->title . ' di ' . $setting->site_name)
            ->setType('article')
            ->setArticle([
                'published_time' => Carbon::parse($tutorial->created_at)->toW3cString() . PHP_EOL,
                'modified_time' => Carbon::parse($tutorial->updated_at)->toW3cString() . PHP_EOL,
                'author' => $author->name,
                'section' => $tutorial->title,
            ]);

        if (file_exists('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail)) {
            OpenGraph::addImage(asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail));
            OpenGraph::addImage(['url' => asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail), 'size' => 800]);
            OpenGraph::addImage(asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail), ['height' => 800, 'width' => 1280]);
            JsonLdMulti::addImage(asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail));
            JsonLdMulti::addImage(asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail));
        } else {
            OpenGraph::addImage(asset('vendor/blog/img/default.png'));
            OpenGraph::addImage(['url' => asset('vendor/blog/img/default.png'), 'size' => 800]);
            OpenGraph::addImage(asset('vendor/blog/img/default.png'), ['height' => 800, 'width' => 1280]);
            JsonLdMulti::addImage(asset('vendor/blog/img/default.png'));
            JsonLdMulti::addImage(asset('vendor/blog/img/default.png'));
        }

        return view('blog.tutorials.blog-user-tutorial', [
            'posts' => $posts,
            'tutorial' => $tutorial,
            'author' => $author,
        ]);
    }

    public function resumeAuthor(User $author, $resume)
    {
        $resume = $author->pf_resume;
        $path = 'vendor/dashboard/documents/resume/' . $resume;

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $resume . '"'
        ]);
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
}
