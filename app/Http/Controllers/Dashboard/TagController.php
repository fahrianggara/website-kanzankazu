<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tag_show', ['only' => 'index']);
        $this->middleware('permission:tag_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tag_update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tag_delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = $request->get('keyword')
            ? Tag::search($request->keyword)->paginate(10)
            : Tag::paginate(10);

        return view('dashboard.manage-posts.tags.index', [
            'tags' => $tags->appends(['keyword' => $request->keyword])
        ]);
    }

    // SELECT
    public function select(Request $request)
    {
        $tags = [];
        if ($request->has('q')) {
            $tags = Tag::select('id', 'title')->search($request->q)->get();
        } else {
            $tags = Tag::select('id', 'title')->limit(5)->get();
        }

        return response()->json($tags);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.manage-posts.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make(
            $request->all(),
            [
                'title'         => 'required|string|max:50|min:3',
                'slug'          => 'required|string|unique:tags,slug',
            ],
        )->validate();

        try {
            Tag::create(
                [
                    'title' => $request->title,
                    'slug'  => $request->slug,
                ]
            );

            return redirect()->route('tags.index')->with('success', 'New tag successfully created!');
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Failed during data input process.
                Message: ' . $th->getMessage()
            );

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('dashboard.manage-posts.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        Validator::make(
            $request->all(),
            [
                'title'         => 'required|string|max:50|min:3',
                'slug'          => 'required|string|unique:tags,slug,' . $tag->id,
            ],
            [],
        )->validate();

        try {
            $tag->title = $request->input('title');
            $tag->slug  = $request->input('slug');

            if ($tag->isDirty()) {

                $tag->update();

                return redirect()->route('tags.index')
                    ->with(
                        'success',
                        'Tag successfully updated!'
                    );
            } else {
                return redirect()->route('tags.index')
                    ->with(
                        'success',
                        'Oops.. nothing seems to be updated!'
                    );
            }
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Failed during data input process.
                Message: ' . $th->getMessage()
            );

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Failed during data input process.
                Message: ' . $th->getMessage()
            );
        }

        return redirect()->back()->with('success', $tag->title . '\'s Tag successfully deleted!');
    }
}
