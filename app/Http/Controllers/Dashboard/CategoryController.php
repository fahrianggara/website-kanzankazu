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
            $categories = Category::select('id', 'title')->where('title', 'LIKE', "%$search%")->onlyParent()->get();
        } else {
            $categories = Category::select('id', 'title')->onlyParent()->get();
        }

        return response()->json($categories);
    }

    public function fetch()
    {
        $categories = Category::onlyParent()->get();
        $output = '';

        if ($categories->count() > 0) {
            $output .= '
                <table id="tableCategory" class="table table-hover align-items-center overflow-hidden">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
           ';
            foreach ($categories as $category) {

                if (file_exists('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail)) {
                    $thumbnail = asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail);
                } else {
                    $thumbnail = asset('vendor/blog/img/default.png');
                }

                $output .= '
                <tr>
                    <td>
                        <a href="javascript:void(0)" class="d-flex align-items-center" style="cursor: default">
                            <img src="' . $thumbnail . '" width="60" class="avatar me-3">
                            <div class="d-block ml-3">
                                <span class="fw-bold name-user">' . $category->title . '</span>
                                <div class="small text-secondary">
                                        ' . substr($category->description, 0, 20) . '...
                                </div>
                            </div>
                        </a>
                    </td>
                    <td>
                        <div class="btn-group dropleft">
                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil uil-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-1">
                                <button value="' . $category->id . '" class="show_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-eye text-primary"></i>
                                    <span class="ml-2">Lihat Kategori</span>
                                </button>
                                <button value="' . $category->id . '" class="edit_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-pen text-warning"></i>
                                    <span class="ml-2">Edit Kategori</span>
                                </button>
                                <button value="' . $category->id . '" data-title="' . $category->title . '" class="del_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-trash text-danger"></i>
                                    <span class="ml-2">Hapus Kategori</span>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            ';
            }
            $output .= '</tbody></table>';
        } else {
            $output .= '
            <div class="card-body">
                <div class="text-center">
                    <p class="card-text">
                        <b>Hmm.. sepertinya kategori postingan belum dibuat</b>
                    </p>
                </div>
            </div>
            ';
        }
        echo $output;
    }

    public function show($id)
    {
        $category = Category::onlyParent()->find($id);

        if ($category) {
            return response()->json([
                'status' => 200,
                'data' => $category
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Kategori tidak ditemukan'
            ]);
        }
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
        $validator = Validator::make(
            $request->all(),
            [
                'title'         => 'required|alpha_spaces|string|max:20|min:3',
                'slug'          => 'unique:categories,slug',
                'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:1024',
                'description'   => 'nullable|max:400|min:10'
            ],
            [
                'title.required'         => 'Wajib di isi',
                'title.alpha_spaces'     => 'Hanya boleh berupa alphabet dan spasi',
                'title.max'              => 'Maksimal hanya 20 karakter',
                'title.min'              => 'Minimal hanya 3 karakter',
                'slug.unique'            => 'Kategori ini sudah ada',
                'thumbnail.image'        => 'Harus berupa gambar',
                'thumbnail.mimes'        => 'Harus bertype jpg, png, jpeg dan gif',
                'thumbnail.max'          => 'Ukuran maksimal harus 1 MB',
                'description.max'        => 'Maksimal hanya 400 karakter',
                'description.min'        => 'Minimal hanya 10 karakter',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray(),
            ]);
        } else {
            // INSERT DATA
            if ($request->hasFile('thumbnail')) {
                $path = "vendor/dashboard/image/thumbnail-categories/";
                $image = $request->file('thumbnail');
                $newImage = uniqid('CateIMG-', true) . '.' . $image->extension();
                // Resize Img
                $resizeImg = Image::make($image->path());
                $resizeImg->fit(1280, 800)->save($path . '/' . $newImage);
            }

            // insert data
            $insert = Category::create([
                'title'         => $request->input('title'),
                'slug'          => $request->input('slug'),
                'description'   => $request->input('description') ?? 'Kategori blog postingan tentang ' . $request->input('title'),
                'thumbnail'     => $newImage ?? 'default.png',
            ]);

            if ($insert) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Kategori baru berhasil ditambahkan',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Oopss.. Kategori gagal ditambahkan',
                ]);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::onlyParent()->find($id);

        if ($category) {
            return response()->json([
                'status' => 200,
                'data' => $category
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Kategori tidak ditemukan'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::onlyParent()->find($id);

        // Validation
        $validator = Validator::make(
            $request->all(),
            [
                'title'         => 'required|alpha_spaces|max:50|min:3',
                'slug'          => 'unique:categories,slug,' . $id,
                'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:1024',
                'description'   => 'nullable|max:400|min:10'
            ],
            [
                'title.required'         => 'Wajib di isi',
                'title.alpha_spaces'     => 'Hanya boleh berupa alphabet dan spasi',
                'title.max'              => 'Maksimal hanya 50 karakter',
                'title.min'              => 'Minimal hanya 3 karakter',
                'slug.unique'            => 'Kategori ini sudah ada',
                'thumbnail.image'        => 'Harus berupa gambar',
                'thumbnail.mimes'        => 'Harus bertype jpg, png, jpeg dan gif',
                'thumbnail.max'          => 'Ukuran maksimal harus 1 MB',
                'description.max'        => 'Maksimal hanya 400 karakter',
                'description.min'        => 'Minimal hanya 10 karakter',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray(),
            ]);
        } else {
            if ($category) {
                $category->title        = $request->input('title');
                $category->slug         = $request->input('slug');
                $category->description  = $request->input('description') ?? 'Kategori blog postingan tentang ' . $category->title;

                if ($request->hasFile('thumbnail')) {
                    $path = "vendor/dashboard/image/thumbnail-categories/";
                    if (File::exists($path . $category->thumbnail)) {
                        File::delete($path . $category->thumbnail);
                    }
                    $image = $request->file('thumbnail');
                    $newImage = uniqid('CateIMG-', true) . '.' . $image->extension();
                    // Resize Img
                    $resizeImg = Image::make($image->path());
                    $resizeImg->fit(1280, 800)->save($path . '/' . $newImage);

                    $category->thumbnail = $newImage;
                }

                if ($category->isDirty()) {

                    $category->update();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Kategori ' . $category->title . ' berhasil diubah'
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Tidak ada perubahan'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Kategori tidak ditemukan'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::onlyParent()->find($id);

        if ($category) {

            $usePostCategory = Post::join('category_post', 'posts.id', '=', 'category_post.post_id')
                ->where('category_post.category_id', $id)->get();

            if ($usePostCategory->count() >= 1) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Oopss.. kategori tidak bisa di hapus, karena kategori ' . $category->title . ' sedang digunakan!'
                ]);
            } else {

                $path = "vendor/dashboard/image/thumbnail-categories/";
                if (File::exists($path . $category->thumbnail)) {
                    File::delete($path . $category->thumbnail);
                }

                $category->delete();

                return response()->json([
                    'status' => 200,
                    'message' => 'Kategori ' . $category->title . ' berhasil dihapus'
                ]);
            }

        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Kategori tidak ditemukan'
            ]);
        }

    }
}
