<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\WebSetting;
use App\Notifications\UserPostApproved;
use App\Notifications\UserPostApprovedEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:post_show', ['only' => 'index']);
        $this->middleware('permission:post_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post_update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post_detail', ['only' => 'show']);
        $this->middleware('permission:post_delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (in_array($request->get('status'), ['publish', 'draft', 'approve'])) {
            if ($request->get('status') == "approve") {
                if (Auth::user()->roles->pluck('name')->contains('Editor')) {
                    return redirect()->route('posts.index')->with('success', 'You are not authorized');
                } else {
                    $statusSelected = $request->get('status');
                }
            } else {
                $statusSelected = $request->get('status');
            }
        } else {
            $statusSelected = "publish";
        }

        if ($statusSelected == "publish") {
            $posts = Post::publish()->where('user_id', Auth::id())->latest();
        } else if ($statusSelected == "draft") {
            $posts = Post::draft()->where('user_id', Auth::id())->latest();
        } else {
            $posts = Post::approve()->latest();
        }

        if ($request->get('keyword')) {
            $posts->search($request->get('keyword'));
        }

        return view('dashboard.manage-posts.posts.index', [
            'posts' => $posts->paginate(8)->withQueryString(),
            'statusSelected' => $statusSelected,
        ]);
    }

    public function publish(Post $post)
    {
        $post->status = 'publish';
        $post->update();

        return redirect()->route('posts.index')->with('success', 'Your post has been Published!');
    }

    public function draft(Post $post)
    {
        $post->status = 'draft';
        $post->update();

        return redirect()->route('posts.index')->with('success', 'Your post has been Drafted!');
    }

    public function approve(Post $post)
    {
        $post->status = 'publish';

        if (auth()->user()) {
            $postUserId = $post->user_id;
            $user = User::find($postUserId);
            $user->notify(new UserPostApproved($post));
        }

        $postUserId = $post->user_id;
        $user = User::find($postUserId);
        $user->notify(new UserPostApprovedEmail($user));

        $post->update();

        return redirect()->route('posts.index')->with('success', 'Post has been Published!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.manage-posts.posts.create', [
            'categories' => Category::with('generation')->onlyParent()->get(),
            'statuses'   => $this->statuses(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'         => 'required|string|max:80|min:5',
                'slug'          => 'required|string|unique:posts,slug',
                'thumbnail'     => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
                'description'   => 'required|max:500|min:10',
                'content'       => 'required|min:10',
                'category'      => 'required',
                'author'        => 'required',
                'tag'           => 'required',
                'status'        => 'required',
                'keywords'      => 'required|string|min:3|max:100',
            ],
        );

        if ($validator->fails()) {
            if ($request['tag']) {
                $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
            }

            return redirect()->back()->withInput($request->all())->withErrors($validator);
        } else {
            // PROSES INPUT DATA
            DB::beginTransaction();
            try {
                if ($request->hasFile('thumbnail')) {
                    $path = public_path("vendor/dashboard/image/thumbnail-posts/");
                    $thumbnail = $request->file('thumbnail');
                    $newThumbnail = uniqid('POST-', true) . '.' . $thumbnail->extension();
                    // Resize Image
                    $reziseThumbnail = Image::make($thumbnail->path());
                    $reziseThumbnail->resize(1280, 800)->save($path . '/' . $newThumbnail);
                }

                $post = Post::create([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'thumbnail' => $newThumbnail,
                    'description' => $request->description,
                    'content' => $request->content,
                    'author' => $request->author,
                    'status' => $request->status,
                    'keywords' => $request->keywords,
                    'user_id' => Auth::user()->id,
                    'views' => 0,
                ]);

                $post->tags()->attach($request->tag);
                $post->categories()->attach($request->category);

                if (Role::where('name', 'Editor')->first()) {
                    return redirect()->route('posts.index')->with('success', 'Your post waiting for approval!');
                } else {
                    if ($post->status == 'publish') {
                        return redirect()->route('posts.index')->with('success', 'New post created successfully!');
                    } else {
                        return redirect()->route('posts.index')->with('success', 'New post has been created in draft option!');
                    }
                }
            } catch (\Throwable $th) {
                DB::rollBack();

                Alert::error(
                    'Error',
                    'Failed during data input process.
                    Message: ' . $th->getMessage()
                );

                if ($request['tag']) {
                    $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
                }

                return redirect()->back()->withInput($request->all());
            } finally {
                DB::commit();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $categories = $post->categories;
        $tags = $post->tags;
        return view('dashboard.manage-posts.posts.show', compact('post', 'tags', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if ($post->user_id == Auth::user()->id) {

            return view('dashboard.manage-posts.posts.edit', [
                'post' => $post,
                'categories' => Category::with('generation')->onlyParent()->get(),
                'statuses'   => $this->statuses(),
            ]);
        } else {
            Alert::error(
                'Error',
                'You are not authorized to edit this post.'
            );

            return redirect()->route('posts.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'         => 'required|string|max:80|min:5',
                'slug'          => 'required|string|unique:posts,slug,' . $post->id,
                'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:2048',
                'description'   => 'required|max:500|min:10',
                'content'       => 'required|min:10',
                'category'      => 'required',
                'tag'           => 'required',
                'keywords'      => 'required|string|min:3|max:100',
            ],
        );

        if ($validator->fails()) {
            if ($request['tag']) {
                $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
            }

            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // PROSES EDIT DATA
        DB::beginTransaction();
        try {
            if ($request->hasFile('thumbnail')) {
                $path = "vendor/dashboard/image/thumbnail-posts/";
                if (File::exists($path . $post->thumbnail)) {
                    File::delete($path . $post->thumbnail);
                }
                $thumbnail = $request->file('thumbnail');
                $newThumbnail = uniqid('POST-', true) . '.' . $thumbnail->extension();
                // Resize Image
                $reziseThumbnail = Image::make($thumbnail->path());
                $reziseThumbnail->resize(1280, 800)->save($path . '/' . $newThumbnail);

                $post->thumbnail = $newThumbnail;
            }

            $post->title = $request->title;
            $post->slug = $request->slug;
            $post->description = $request->description;
            $post->content = $request->content;
            $post->keywords = $request->keywords;
            $post->tags()->sync($request->tag);
            $post->categories()->sync($request->category);

            $post->update();

            return redirect()->route('posts.index')
                ->with(
                    'success',
                    'Post updated successfully!'
                );
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Failed during data input process.
                Message: ' . $th->getMessage()
            );

            if ($request['tag']) {
                $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
            }

            return redirect()->back()->withInput($request->all());
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        try {
            $post->tags()->detach();
            $post->categories()->detach();

            $path = "vendor/dashboard/image/thumbnail-posts/";
            if (File::exists($path . $post->thumbnail)) {
                File::delete($path . $post->thumbnail);
            }

            $post->delete();

            return redirect()->route('posts.index')->with(
                'success',
                "Post with \"" . $post->title . "\", Deleted Successfully"
            );
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Failed during data input process.
                Message: ' . $th->getMessage()
            );
        } finally {
            DB::commit();
        }

        return redirect()->back();
    }

    private function statuses()
    {
        return [
            'publish'   => "Publish",
            'draft'     => "Draft",
            'approve'   => "Approve"
        ];
    }

    private function editorRole()
    {
        return $this->roles()->where('name', 'Editor')->first();
    }
}
