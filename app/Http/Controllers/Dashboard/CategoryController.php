<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category_show', ['only' => 'index']);
        $this->middleware('permission:category_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category_update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category_delete', ['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::with('generation');

        if ($request->has('keyword') && trim($request->keyword)) {
            $categories->search($request->keyword);
        } else {
            $categories->onlyParent();
        }

        return view('dashboard.manage-posts.categories.index', [
            'categories' => $categories->latest()->paginate(10)->appends(['keyword' => $request->get('keyword')])
        ]);
    }

    // SELECT PARENT
    public function select(Request $request)
    {
        $categories = [];
        if ($request->has('q')) {
            $search = $request->q;
            $categories = Category::select('id', 'title')->where('title', 'LIKE', "%$search%")->limit(5)->get();
        } else {
            $categories = Category::select('id', 'title')->onlyParent()->limit(5)->get();
        }

        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.manage-posts.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:20|min:3',
            'slug'          => 'unique:categories,slug',
            'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:2048',
            'description'   => 'nullable|max:400|min:10'
        ]);

        if ($validator->fails()) {
            if ($request->has('parent_category')) {
                $request['parent_category'] = Category::select('id', 'title')->find($request->parent_category);
            }
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        } else {

            // INSERT DATA
            if ($request->hasFile('thumbnail')) {
                $path = public_path("vendor/dashboard/image/thumbnail-categories/");
                $image = $request->file('thumbnail');
                $newImage = uniqid('CateIMG-', true) . '.' . $image->extension();
                // Resize Img
                $resizeImg = Image::make($image->path());
                $resizeImg->resize(1280, 800)->save($path . '/' . $newImage);
            }

            // insert data
            $insert = Category::create([
                'title'         => $request->title,
                'slug'          => $request->slug,
                'description'   => $request->description ?? '',
                'thumbnail'     => $newImage ?? 'default.png',
                'parent_id'     => $request->parent_category
            ]);

            if ($insert) {
                // Alert success
                return redirect()->route('categories.index')->with(
                    'success',
                    'New Category has been saved!'
                );
            } else {
                // Jika gagal
                if ($request->has('parent_category')) {
                    $request['parent_category'] = Category::select('id', 'title')->find($request->parent_category);
                }

                return redirect()->back()->withInput($request->all());
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.manage-posts.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // Validation
        $validator = Validator::make(
            $request->all(),
            [
                'title'         => 'required|string|max:50',
                'slug'          => 'required|string|unique:categories,slug,' . $category->id,
                'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:2048',
                'description'   => 'nullable|max:400|min:10'
            ],
        );

        if ($validator->fails()) {
            if ($request->has('parent_category')) {
                $request['parent_category'] = Category::select('id', 'title')->find($request->parent_category);
            }
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        } else {
            // UPDATE CATEGORY
            $category->title        = $request->input('title');
            $category->slug         = $request->input('slug');
            $category->description  = $request->input('description') ?? '';
            $category->parent_id    = $request->input('parent_category');

            if ($request->hasFile('thumbnail')) {
                $path = "vendor/dashboard/image/thumbnail-categories/";
                if (File::exists($path . $category->thumbnail)) {
                    File::delete($path . $category->thumbnail);
                }
                $image = $request->file('thumbnail');
                $newImage = uniqid('CateIMG-', true) . '.' . $image->extension();
                // Resize Img
                $resizeImg = Image::make($image->path());
                $resizeImg->resize(1280, 800)->save(public_path($path) . '/' . $newImage);

                $category->thumbnail = $newImage;
            }

            if ($category->isDirty()) {

                // Updated process
                $cateUpdate = $category->update();

                if ($cateUpdate) {
                    return redirect()->route('categories.index')->with(
                        'success',
                        'Category successfully updated!'
                    );
                } else {
                    if ($request->has('parent_category')) {
                        $request['parent_category'] = Category::select('id', 'title')->find($request->parent_category);
                    }
                    return redirect()->back()->withInput($request->all());
                }
            } else {
                return redirect()->route('categories.index')->with(
                    'success',
                    'Oops.. nothing seems to be updated!'
                );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            // Delete image data category
            $path = "vendor/dashboard/image/thumbnail-categories/";
            if (File::exists($path . $category->thumbnail)) {
                File::delete($path . $category->thumbnail);
            }
            // Delete data
            $category->delete();
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Failed during data input process.
                Message: ' . $th->getMessage()
            );
        }

        return redirect()->back()->with(
            'success',
            $category->title . ' category successfully Deleted!'
        );
    }
}
