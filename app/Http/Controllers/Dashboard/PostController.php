<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\NewPost;
use App\Models\Post;
use App\Models\Category;
use App\Models\Newsletter;
use App\Models\RecommendationPost;
use App\Models\Tag;
use App\Models\Tutorial;
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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

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
    public function index(Request $request, Post $post)
    {
        if (in_array($request->get('status'), ['publish', 'draft', 'approve'])) {
            if ($request->get('status') == "approve") {
                if (Auth::user()->roles->pluck('name')->contains('Editor')) {
                    return redirect()->route('posts.index')->with('success', 'Oops.. kamu tidak bisa mengakses halaman ini.');
                } else {
                    $statusSelected = $request->get('status');
                }
            } else {
                $statusSelected = $request->get('status');
            }
        } else {
            $statusSelected = "publish";
        }

        // Main view
        if ($statusSelected == "publish") {
            $posts = Post::publish()
                ->where('posts.user_id', Auth::id())
                ->orderBy(RecommendationPost::select('post_id')->whereColumn('post_id', 'posts.id'), 'desc');
        } else if ($statusSelected == "draft") {
            $posts = Post::draft()
                ->where('posts.user_id', Auth::id())
                ->orderBy(RecommendationPost::select('post_id')->whereColumn('post_id', 'posts.id'), 'desc');
        } else {
            $posts = Post::approve();
        }

        $q = $request->keyword;

        if ($q) {
            $posts->search($q);
        }

        return view('dashboard.manage-posts.posts.index', [
            'posts' => $posts->paginate(12)->withQueryString(),
            'statusSelected' => $statusSelected,
            'cateOld' => $post->categories->first(),
            'tutoOld' => $post->tutorials->first(),
            'tagOld' => $post->tags->first(),
            'publishPostCount' => Post::publish()->where('user_id', Auth::id())->count(),
            'draftPostCount' => Post::draft()->where('user_id', Auth::id())->count(),
            'approvePostCount' => Post::approve()->count(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $post = Post::with('categories', 'tags')->where('slug', $slug)->first();

        if (($post->title != null && $post->description != null) && ($post->categories->first() != null && $post->tags->first() != null)) {
            $nextPublish = Post::publish()->where('user_id', Auth::id())
                ->where('id', '>', $post->id)
                ->min('id');
            $prevPublish = Post::publish()->where('user_id', Auth::id())
                ->where('id', '<', $post->id)
                ->max('id');

            $nextDraft = Post::draft()->where('user_id', Auth::id())
                ->where('id', '>', $post->id)
                ->min('id');
            $prevDraft = Post::draft()->where('user_id', Auth::id())
                ->where('id', '<', $post->id)
                ->max('id');

            return view('dashboard.manage-posts.posts.show', [
                'post' => $post,
                'tags' => $post->tags,
                'categories' => $post->categories,
                'nextPublish' => Post::find($nextPublish),
                'prevPublish' => Post::find($prevPublish),
                'nextDraft' => Post::find($nextDraft),
                'prevDraft' => Post::find($prevDraft),
            ]);
        } else {
            Alert::warning(
                'Oops..',
                'kamu tidak bisa melihat postingan kamu, ketika semua isinya masih kosong. silahkan isi semua kontennya terlebih dahulu!'
            )->autoClose(false);

            return Redirect::to(URL::route('posts.index') . '?status=draft');

        }
    }

    public function recommend($id)
    {
        $post = Post::join('recommendation_posts', 'posts.id', '=', 'recommendation_posts.post_id')
            ->where('post_id', $id)
            ->get();

        $recommendPost = RecommendationPost::where('user_id', Auth::id())->get();

        if ($post->isEmpty()) {
            // validation max 3
            if ($recommendPost->count() >= 3) {
                Alert::warning(
                    'Oops..',
                    'Rekomendasi maksimal 3 postingan! silahkan hapus rekomandasi yang lainnya untuk direkomendasikan.'
                )->autoClose(false);

                RecommendationPost::where('post_id', $id)
                    ->where('user_id', Auth::id())
                    ->delete();
                return redirect()->back();
            } else {
                RecommendationPost::create([
                    'post_id' => $id,
                    'user_id' => Auth::id(),
                ]);
                return redirect()->back()->with('success', 'Postingan kamu telah direkomendasikan.');
            }
        } else {
            RecommendationPost::where('post_id', $id)
                ->where('user_id', Auth::id())
                ->delete();
            return redirect()->back()->with('success', 'Postingan kamu batal direkomendasikan.');
        }
    }

    public function publish(Post $post)
    {
        $post->status = 'publish';
        $post->update();

        return redirect()->back()->with('success', 'Postingan kamu berhasil di publik!');
    }

    public function draft(Post $post)
    {
        $post->status = 'draft';
        $post->update();

        return redirect()->back()->with('success', 'Postingan kamu telah disimpan ke dalam arsip!');
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

        return redirect()->back()->with('success', 'Postingan berhasil disetujui!');
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
            'tutorials' => Tutorial::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $data)
    {
        if (Auth::user()->roles->pluck('name')->contains('Editor')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'title'         => 'required|string|max:80|min:5',
                    'slug'          => 'unique:posts,slug',
                    'thumbnail'     => 'required|image|mimes:jpg,png,jpeg,gif|max:1024',
                    'description'   => 'required|max:500|min:10',
                    'content'       => 'required|min:3',
                    'category'      => 'required',
                    'tag'           => 'required',
                    'status'        => 'required',
                    'keywords'      => 'required|string|min:3|max:100',
                ],
                [
                    'title.required'         => 'Wajib harus diisi!',
                    'title.string'           => 'Harus berupa string!',
                    'title.max'              => 'Maksimal 80 karakter!',
                    'title.min'              => 'Minimal 5 karakter!',
                    'slug.unique'            => 'Postingan sudah ada!',
                    'thumbnail.required'     => 'Wajib harus diisi!',
                    'thumbnail.image'        => 'Harus berupa gambar!',
                    'thumbnail.mimes'        => 'Gambar harus berformat jpg, png, jpeg dan gif!',
                    'thumbnail.max'          => 'Ukuran gambar maksimal 1 MB!',
                    'description.required'   => 'Wajib harus diisi!',
                    'description.max'        => 'Maksimal 500 karakter!',
                    'description.min'        => 'Minimal 10 karakter!',
                    'content.required'       => 'Wajib harus diisi!',
                    'content.min'            => 'Minimal 3 karakter!',
                    'category.required'      => 'Wajib harus diisi!',
                    'tag.required'           => 'Wajib harus diisi!',
                    'status.required'        => 'Wajib harus diisi!',
                    'keywords.required'      => 'Wajib harus diisi!',
                    'keywords.string'        => 'Harus berupa string!',
                    'keywords.min'           => 'Minimal 3 karakter!',
                    'keywords.max'           => 'Maksimal 100 karakter!',
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'title'         => 'nullable|string|max:80|min:5',
                    'slug'          => 'unique:posts,slug',
                    'thumbnail'     => 'nullable|image|mimes:jpg,png,jpeg,gif|max:1024',
                    'description'   => 'nullable|max:500|min:10',
                    'content'       => 'required|min:10',
                    'category'      => 'nullable',
                    'tutorial'      => 'nullable',
                    'tag'           => 'nullable',
                    'status'        => 'nullable',
                    'keywords'      => 'nullable|string|min:3|max:100',
                ],
                [
                    'title.required'         => 'Wajib harus diisi!',
                    'title.string'           => 'Harus berupa string!',
                    'title.max'              => 'Maksimal 80 karakter!',
                    'title.min'              => 'Minimal 5 karakter!',
                    'slug.unique'            => 'Postingan sudah ada!',
                    'thumbnail.required'     => 'Wajib harus diisi!',
                    'thumbnail.image'        => 'Harus berupa gambar!',
                    'thumbnail.mimes'        => 'Gambar harus berformat jpg, png, jpeg dan gif!',
                    'thumbnail.max'          => 'Ukuran gambar maksimal 1 MB!',
                    'description.required'   => 'Wajib harus diisi!',
                    'description.max'        => 'Maksimal 500 karakter!',
                    'description.min'        => 'Minimal 10 karakter!',
                    'content.required'       => 'Form konten postingan kamu wajib harus diisi !',
                    'content.min'            => 'Minimal 10 karakter!',
                    'category.required'      => 'Wajib harus diisi!',
                    'tag.required'           => 'Wajib harus diisi!',
                    'status.required'        => 'Wajib harus diisi!',
                    'keywords.required'      => 'Wajib harus diisi!',
                    'keywords.string'        => 'Harus berupa string!',
                    'keywords.min'           => 'Minimal 3 karakter!',
                    'keywords.max'           => 'Maksimal 100 karakter!',
                ]
            );
        }

        if ($validator->fails()) {

            if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                $request['tutorial'] = Tutorial::select('id', 'title')->find($request->tutorial);
            }
            if ($request['tag']) {
                $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
            }

            $request['category'] = Category::select('id', 'title')->find($request->category);

            return redirect()->back()->withInput($request->all())->withErrors($validator);
        } else {
            // PROSES INPUT DATA
            DB::beginTransaction();
            try {
                $randomStr = Str::random(5);

                $statusDraft = $request->title == '' || $request->description == '' || $request->keywords == '' || $request->tag == '' || $request->category == '';

                // Validation lebih dari 3 tag
                if (count((array)$request['tag']) >= 4) {
                    if ($request['tag']) {
                        $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request['tag'])->get();
                    }

                    if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                        $request['tutorial'] = Tutorial::select('id', 'title')->find($request->tutorial);
                    }

                    $request['category'] = Category::select('id', 'title')->find($request->category);

                    Alert::warning(
                        'Oops..',
                        'kamu tidak bisa pilih tag postingan lebih dari 3 ! sedangkan kamu pilih ' . count($request['tag']) . ' tag postingan! silahkan hapus salah satunya.'
                    )->autoClose(false);

                    return redirect()->back()->withInput($request->all())->withErrors($validator);
                }

                if ($request->hasFile('thumbnail')) {
                    $path = "vendor/dashboard/image/thumbnail-posts/";
                    $thumbnail = $request->file('thumbnail');
                    $newThumbnail = uniqid('POST-', true) . '.' . $thumbnail->extension();
                    // Resize Image
                    $reziseThumbnail = Image::make($thumbnail->path());
                    $reziseThumbnail->fit(1280, 800)->save($path . '/' . $newThumbnail);
                }

                if (Auth::user()->roles->pluck('name')->contains('Editor')) {
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
                } else {
                    $post = Post::create([
                        'title' => $request->title,
                        'slug' => $request->slug ?? strtolower($randomStr),
                        'thumbnail' => $newThumbnail ?? 'default.png',
                        'description' => $request->description,
                        'content' => $request->content,
                        'author' => $request->author,
                        'status' => $statusDraft ? 'draft' : $request->status,
                        'keywords' => $request->keywords,
                        'user_id' => Auth::user()->id,
                        'views' => 0,
                        'tutorial_id' => $request->tutorial,
                    ]);
                }

                $post->tags()->attach($request->tag);
                $post->categories()->attach($request->category);

                if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                    $post->tutorials()->attach($request->tutorial, ['user_id' => Auth::user()->id]);
                }

                if (Auth::user()->roles->pluck('name')->contains('Editor')) {
                    return redirect()->route('posts.index')->with('success', 'Postingan kamu sedang menunggu persetujuan dari mimin!');
                } else {
                    if ($post->status == 'publish') {
                        $data = Newsletter::select('email')->get();

                        foreach ($data as $item) {
                            Mail::to($item->email)->send(new NewPost($post));
                        }
                        return redirect()->route('posts.index')->with('success', 'Postingan baru berhasil ditambahkan!');
                    } else {
                        return redirect()->route('posts.index')->with('success', 'Postingan baru berhasil ditambahkan didalam arsip kamu!');
                    }
                }
            } catch (\Throwable $th) {
                DB::rollBack();

                Alert::error(
                    'Error',
                    'Terjadi kesalahan saat menyimpan postingan.
                Pesan: ' . $th->getMessage()
                )->autoClose(false);

                if ($request['tag']) {
                    $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
                }
                $request['category'] = Category::select('id', 'title')->find($request->category);
                if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                    $request['tutorial'] = Tutorial::select('id', 'title')->find($request->tutorial);
                }

                return redirect()->back()->withInput($request->all());
            } finally {
                DB::commit();
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::with('categories', 'tags', 'tutorials')->where('slug', $slug)->first();
        $cateOld = $post->categories->first();

        if ($post->user_id == Auth::user()->id) {

            return view('dashboard.manage-posts.posts.edit', [
                'post' => $post,
                'categories' => Category::with('generation')->onlyParent()->get(),
                'tutorials' => Tutorial::all(),
                'cateOld' => $post->categories->first(),
                'tutoOld' => $post->tutorials->first(),
            ]);
        } else {
            Alert::error(
                'Error',
                'Oops.. Kamu tidak dapat mengedit postingan ini!'
            )->autoClose(false);

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
        if (Auth::user()->roles->pluck('name')->contains('Editor')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'title'         => 'required|string|max:80|min:5',
                    'slug'          => 'unique:posts,slug,' . $post->id,
                    'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:1024',
                    'description'   => 'required|max:500|min:10',
                    'content'       => 'required|min:10',
                    'category'      => 'required',
                    'tag'           => 'required',
                    'keywords'      => 'required|string|min:3|max:100',
                ],
                [
                    'title.required'         => 'Wajib harus diisi!',
                    'title.string'           => 'Harus berupa string!',
                    'title.max'              => 'Maksimal 80 karakter!',
                    'title.min'              => 'Minimal 5 karakter!',
                    'slug.unique'            => 'Postingan sudah ada!',
                    'thumbnail.image'        => 'Harus berupa gambar!',
                    'thumbnail.mimes'        => 'Gambar harus berformat jpg, png, jpeg dan gif!',
                    'thumbnail.max'          => 'Ukuran gambar maksimal 1 MB!',
                    'description.required'   => 'Wajib harus diisi!',
                    'description.max'        => 'Maksimal 500 karakter!',
                    'description.min'        => 'Minimal 10 karakter!',
                    'content.required'       => 'Wajib harus diisi!',
                    'content.min'            => 'Minimal 10 karakter!',
                    'category.required'      => 'Wajib harus diisi!',
                    'tag.required'           => 'Wajib harus diisi!',
                    'keywords.required'      => 'Wajib harus diisi!',
                    'keywords.string'        => 'Harus berupa string!',
                    'keywords.min'           => 'Minimal 3 karakter!',
                    'keywords.max'           => 'Maksimal 100 karakter!',
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'title'         => 'nullable|string|max:80|min:5',
                    'slug'          => 'unique:posts,slug,' . $post->id,
                    'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:1024',
                    'description'   => 'nullable|max:500|min:10',
                    'content'       => 'nullable|min:10',
                    'category'      => 'nullable',
                    'tutorial'      => 'nullable',
                    'tag'           => 'nullable',
                    'keywords'      => 'nullable|string|min:3|max:100',
                ],
                [
                    'title.required'         => 'Wajib harus diisi!',
                    'title.string'           => 'Harus berupa string!',
                    'title.max'              => 'Maksimal 80 karakter!',
                    'title.min'              => 'Minimal 5 karakter!',
                    'slug.unique'            => 'Postingan sudah ada!',
                    'thumbnail.image'        => 'Harus berupa gambar!',
                    'thumbnail.mimes'        => 'Gambar harus berformat jpg, png, jpeg dan gif!',
                    'thumbnail.max'          => 'Ukuran gambar maksimal 1 MB!',
                    'description.required'   => 'Wajib harus diisi!',
                    'description.max'        => 'Maksimal 500 karakter!',
                    'description.min'        => 'Minimal 10 karakter!',
                    'content.required'       => 'Wajib harus diisi!',
                    'content.min'            => 'Minimal 10 karakter!',
                    'category.required'      => 'Wajib harus diisi!',
                    'tag.required'           => 'Wajib harus diisi!',
                    'keywords.required'      => 'Wajib harus diisi!',
                    'keywords.string'        => 'Harus berupa string!',
                    'keywords.min'           => 'Minimal 3 karakter!',
                    'keywords.max'           => 'Maksimal 100 karakter!',
                ]
            );
        }

        if ($validator->fails()) {

            if ($request['tag']) {
                $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
            }
            if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                $request['tutorial'] = Tutorial::select('id', 'title')->find($request->tutorial);
            }
            $request['category'] = Category::select('id', 'title')->find($request->category);

            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        // PROSES EDIT DATA
        DB::beginTransaction();
        try {
            if ($request->hasFile('thumbnail')) {
                // $public_path = '../../public_html/blog/';
                // $path = $public_path . "vendor/dashboard/image/thumbnail-posts/";
                $path = "vendor/dashboard/image/thumbnail-posts/";
                if (File::exists($path . $post->thumbnail)) {
                    File::delete($path . $post->thumbnail);
                }
                $thumbnail = $request->file('thumbnail');
                $newThumbnail = uniqid('POST-', true) . '.' . $thumbnail->extension();
                // Resize Image
                $reziseThumbnail = Image::make($thumbnail->path());
                $reziseThumbnail->fit(1280, 800)->save($path . '/' . $newThumbnail);

                $post->thumbnail = $newThumbnail;
            }

            $randomStr = Str::random(5);

            $post->title = $request->title;
            $post->slug = $request->slug ?? strtolower($randomStr);
            $post->description = $request->description;
            $post->content = $request->content;
            $post->keywords = $request->keywords;
            $post->tutorial_id = $request->tutorial;
            $post->tags()->sync($request->tag);

            if ($post->categories()->first() != null) {
                $post->categories()->sync($request->category);
            } else {
                $post->categories()->attach($request->category);
            }

            if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                if ($post->tutorials()->first() != null) {
                    $post->tutorials()->syncWithPivotValues($request->tutorial, ['user_id' => Auth::id()]);
                } else {
                    $post->tutorials()->attach($request->tutorial, ['user_id' => Auth::id()]);
                }
            }

            // Validasi 4 postingan
            if (count((array)$request['tag']) >= 4) {
                if ($request['tag']) {
                    $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
                }
                if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                    $request['tutorial'] = Tutorial::select('id', 'title')->find($request->tutorial);
                }
                $request['category'] = Category::select('id', 'title')->find($request->category);

                Alert::warning(
                    'Oops..',
                    'kamu tidak bisa pilih tag postingan lebih dari 3 ! sedangkan kamu pilih ' . count($request['tag']) . ' tag postingan! silahkan hapus salah satunya.'
                )->autoClose(false);

                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }

            $post->update();

            if ($post->title === null || $post->description === null || $post->keywords === null || $post->categories->first() === null || $post->tags->first() === null) {
                if ($post->status === 'publish') {

                    $post->status = 'draft';
                    $post->update();

                    return Redirect::to(URL::route('posts.edit', ['slug' => $post->slug]) . '#content')->with('success', 'Postingan berhasil diperbarui.');
                } else {
                    return Redirect::to(URL::route('posts.edit', ['slug' => $post->slug]) . '#content')->with('success', 'Postingan berhasil diperbarui.');
                }
            }

            if ($post->status == 'draft') {
                return Redirect::to(URL::route('posts.index') . '?status=draft')->with('success', 'Postingan berhasil diperbarui!');
            } else {
                return Redirect::to(URL::route('posts.index'))->with('success', 'Postingan berhasil diperbarui!');
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Terjadi kesalahan saat memperbarui postingan.
                Pesan: ' . $th->getMessage()
            )->autoClose(false);

            if ($request['tag']) {
                $request['tag'] = Tag::select('id', 'title')->whereIn('id', $request->tag)->get();
            }
            $request['category'] = Category::select('id', 'title')->find($request->category);

            if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                $request['tutorial'] = Tutorial::select('id', 'title')->find($request->tutorial);
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
            if (!Auth::user()->roles->pluck('name')->contains('Editor')) {
                $post->tutorials()->detach();
            }

            // $public_path = '../../public_html/blog/';
            // $path = $public_path . "vendor/dashboard/image/thumbnail-posts/";
            $path = "vendor/dashboard/image/thumbnail-posts/";
            if (File::exists($path . $post->thumbnail)) {
                File::delete($path . $post->thumbnail);
            }

            $post->delete();

            if ($post->title == null) {
                return redirect()->back()->with(
                    'success',
                    "Postingan \"" . $post->slug . "\", Berhasil dihapus!"
                );
            } else {
                return redirect()->back()->with(
                    'success',
                    "Postingan \"" . $post->title . "\", Berhasil dihapus!"
                );
            }
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Terjadi kesalahan saat menghapus postingan.
                Pesan: ' . $th->getMessage()
            )->autoClose(false);
        } finally {
            DB::commit();
        }

        return redirect()->back();
    }
}
