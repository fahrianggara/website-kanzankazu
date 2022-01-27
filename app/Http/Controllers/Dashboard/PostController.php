<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

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
        $statusSelected = in_array($request->get('status'), ['publish', 'draft']) ? $request->get('status') : "publish";

        $posts = $statusSelected == "publish" ? Post::publish() : Post::draft();

        if ($request->get('keyword')) {
            $posts->search($request->get('keyword'));
        }

        return view('manage-posts.posts.index', [
            'posts' => $posts->paginate(18)->withQueryString(),
            'statuses'  => $this->statuses(),
            'statusSelected' => $statusSelected,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage-posts.posts.create', [
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
                'title'         => 'required|string|max:100',
                'slug'          => 'required|string|unique:posts,slug',
                'thumbnail'     => 'required',
                'description'   => 'required|max:500|min:10',
                'content'       => 'required|min:10',
                'category'      => 'required',
                'author'      => 'required',
                'tag'           => 'required',
                'status'        => 'required',
            ],
        );

        if ($validator->fails()) {
            if ($request['tag']) {
                $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
            }

            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // PROSES INPUT DATA
        DB::beginTransaction();
        try {
            $post = Post::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'thumbnail' => parse_url($request->thumbnail)['path'],
                'description' => $request->description,
                'content' => $request->content,
                'author' => $request->author,
                'status' => $request->status,
                'user_id' => Auth::user()->id,
                'views' => 0,
            ]);

            $post->tags()->attach($request->tag);
            $post->categories()->attach($request->category);

            Alert::success('Success', 'New post created successfully');

            return redirect()->route('posts.index');
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
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $categories = $post->categories;
        $tags = $post->tags;
        return view('manage-posts.posts.show', compact('post', 'tags', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('manage-posts.posts.edit', [
            'post'          => $post,
            'categories'    => Category::with('generation')->onlyParent()->get(),
            'statuses'      => $this->statuses(),
        ]);
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
                'title'         => 'required|string|max:100',
                'slug'          => 'required|string|unique:posts,slug,' . $post->id,
                'thumbnail'     => 'required',
                'description'   => 'required|max:500|min:10',
                'content'       => 'required|min:10',
                'category'      => 'required',
                'tag'           => 'required',
                'status'        => 'required',
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
            $post->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'thumbnail' => parse_url($request->thumbnail)['path'],
                'description' => $request->description,
                'content' => $request->content,
                'author' => Auth::user()->name,
                'status' => $request->status,
                'user_id' => Auth::user()->id,
            ]);

            $post->tags()->sync($request->tag);
            $post->categories()->sync($request->category);

            Alert::success('Success', "Post with \"" . $request->title . "\" title, Updated successfully");

            return redirect()->route('posts.index');
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
        // $post = Post::findorfail($post);

        DB::beginTransaction();
        try {
            $post->tags()->sync();
            $post->categories()->sync();

            $post->delete();

            Alert::success('Success', "Post with \"" . $post->title . "\" title, Deleted Successfully");

            return redirect()->route('posts.index');
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
        ];
    }
}
