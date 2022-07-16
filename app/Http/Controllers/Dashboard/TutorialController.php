<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->get('keyword');

        if ($q) {
            $tutorials = Tutorial::where('title', 'LIKE', "%$q%")
                ->orderBy('title', 'asc')
                ->paginate(10);
        } else {
            $tutorials = Tutorial::orderBy('title', 'asc')
                ->paginate(10);
        }
        return view('dashboard.manage-posts.tutorials.index', [
            'tutorials' => $tutorials->appends(['keyword' => $request->keyword]),
        ]);
    }

    public function select(Request $request)
    {
        $tutorials = [];
        if ($request->has('q')) {
            $search = $request->q;
            $tutorials = Tutorial::select('id', 'title')->where('title', 'LIKE', "%$search%")->get();
        } else {
            $tutorials = Tutorial::select('id', 'title')->get();
        }

        return response()->json($tutorials);
    }

    public function fetch()
    {
        $tutorials = Tutorial::all();
        $output = '';

        if ($tutorials->count() > 0) {
            $output .= '
                <table id="tableTutorial" class="table table-hover align-items-center overflow-hidden">
                    <thead>
                        <tr>
                            <th>Tutorial</th>
                            <th></th>
                        </tr>
                    </thead>
                <tbody>
            ';
            foreach ($tutorials as $tutorial) {
                if (file_exists('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail)) {
                    $thumbnail = asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail);
                } else {
                    $thumbnail = asset('vendor/blog/img/default.png');
                }

                $output .= '
                <tr>
                    <td>
                        <a href="javascript:void(0)" class="d-flex align-items-center" style="cursor: default">
                            <img src="' . $thumbnail . '" width="60" class="avatar me-3">
                            <div class="d-block ml-3">
                                <span class="fw-bold" style="color:' . $tutorial->bg_color . '">' . $tutorial->title . '</span>
                                <div class="small text-secondary">
                                    ' . substr($tutorial->description, 0, 20) . '...
                                </div>
                            </div>
                        </a>
                    </td>
                    <td>
                        <div class="btn-group dropleft">
                            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="uil uil-ellipsis-v" style="color:' . $tutorial->bg_color . '"></i>
                            </button>
                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-1">
                                <button value="' . $tutorial->id . '" class="show_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-eye text-primary"></i>
                                    <span class="ml-2">Lihat Tutorial</span>
                                </button>
                                <button value="' . $tutorial->id . '" class="edit_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-pen text-warning"></i>
                                    <span class="ml-2">Edit Tutorial</span>
                                </button>
                                <button value="' . $tutorial->id . '" data-title="' . $tutorial->title . '" data-color="' . $tutorial->bg_color . '" class="del_btn dropdown-item d-flex align-items-center">
                                    <i class="uil uil-trash text-danger"></i>
                                    <span class="ml-2">Hapus Tutorial</span>
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
                            <b>Hmm.. sepertinya tutorial postingan belum dibuat</b>
                        </p>
                    </div>
                </div>
            ';
        }
        echo $output;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.manage-posts.tutorials.create');
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
                'title'         => 'required|string|max:20|min:3',
                'slug'          => 'unique:tutorials,slug',
                'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:1024',
                'description'   => 'nullable|max:400|min:5',
                'bg_color'      => 'required',
            ],
            [
                'title.required'         => 'Wajib diisi',
                'title.max'              => 'Maksimal hanya 20 karakter',
                'title.min'              => 'Minimal hanya 3 karakter',
                'slug.unique'            => 'Tutorial ini sudah ada, silahkan buat tutorial yang lain',
                'thumbnail.image'        => 'Harus berupa gambar',
                'thumbnail.mimes'        => 'Harus bertype jpg, png, jpeg dan gif',
                'thumbnail.max'          => 'Ukuran maksimal harus 1 MB',
                'description.max'        => 'Maksimal hanya 400 karakter',
                'description.min'        => 'Minimal hanya 5 karakter',
                'bg_color.required'      => 'Wajib diisi',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray(),
            ]);
        } else {

            try {
                if ($request->hasFile('thumbnail')) {
                    $path = 'vendor/dashboard/image/thumbnail-tutorials/';
                    $image = $request->file('thumbnail');
                    $newImage = uniqid('TutorIMG-') . '.' . $image->extension();
                    // Resize
                    $resizeImg = Image::make($image->path());
                    $resizeImg->fit(1280, 800)->save($path . '/' . $newImage);
                }

                $insert = Tutorial::create([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'description' => $request->description ?? 'Tutorial blog postingan tentang ' . $request->title,
                    'thumbnail' => $newImage ?? 'default.png',
                    'bg_color' => $request->bg_color,
                ]);

                if ($insert) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Tutorial baru berhasil ditambahkan!'
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Gagal membuat tutorial!'
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Pesan: ' . $th->getMessage()
                ]);
            }
        }
    }

    public function show($id)
    {
        $tutorial = Tutorial::find($id);

        if ($tutorial) {
            return response()->json([
                'status' => 200,
                'data' => $tutorial
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Tutorial tidak ditemukan'
            ]);
        }
    }

    public function edit($id)
    {
        $tutorial = Tutorial::find($id);

        if ($tutorial) {
            return response()->json([
                'status' => 200,
                'data' => $tutorial
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Tutorial tidak ditemukan'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tutorial = Tutorial::find($id);

        $validator = Validator::make(
            $request->all(),
            [
                'title'         => 'required|string|max:20|min:3',
                'slug'          => 'unique:tutorials,slug,' . $id,
                'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:1024',
                'description'   => 'nullable|max:400|min:5',
                'bg_color'      => 'required',
            ],
            [
                'title.required'         => 'Wajib diisi',
                'title.max'              => 'Maksimal hanya 20 karakter',
                'title.min'              => 'Minimal hanya 3 karakter',
                'slug.unique'            => 'Tutorial ini sudah ada, silahkan buat tutorial yang lain',
                'thumbnail.image'        => 'Harus berupa gambar',
                'thumbnail.mimes'        => 'Harus bertype jpg, png, jpeg dan gif',
                'thumbnail.max'          => 'Ukuran maksimal harus 1 MB',
                'description.max'        => 'Maksimal hanya 400 karakter',
                'description.min'        => 'Minimal hanya 5 karakter',
                'bg_color.required'      => 'Wajib diisi',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray(),
            ]);
        } else {
            try {
                if ($tutorial) {
                    $tutorial->title = $request->title;
                    $tutorial->slug = $request->slug;
                    $tutorial->description = $request->description ?? 'Tutorial blog postingan tentang ' . $tutorial->title;
                    $tutorial->bg_color = $request->bg_color;

                    if ($request->hasFile('thumbnail')) {
                        $path = 'vendor/dashboard/image/thumbnail-tutorials/';
                        if (File::exists($path . $tutorial->thumbnail)) {
                            File::delete($path . $tutorial->thumbnail);
                        }
                        $image = $request->file('thumbnail');
                        $newImage = uniqid('TutorIMG-') . '.' . $image->extension();
                        // Resize
                        $resizeImg = Image::make($image->path());
                        $resizeImg->fit(1280, 800)->save($path . '/' . $newImage);

                        $tutorial->thumbnail = $newImage;
                    }

                    if ($tutorial->isDirty()) {

                        $tutorial->update();

                        return response()->json([
                            'status' => 200,
                            'message' => 'Tutorial ' . $tutorial->title . ' berhasil diperbarui',
                        ]);
                    } else {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Hmm.. sepertinya tidak ada perubahan',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Data kategori tidak ditemukan!',
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Error : ' . $th->getMessage(),
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tutorial = Tutorial::find($id);

        $usePostTutorial = Post::join('post_tutorial', 'posts.id', '=', 'post_tutorial.post_id')
            ->where('post_tutorial.tutorial_id', $id)->get();

        if ($usePostTutorial->count() >= 1) {
            return response()->json([
                'status' => 500,
                'message' => "Oops.. tutorial " . $tutorial->title . " tidak bisa hapus, karena tutorial ini sedang digunakan."
            ]);
        }

        try {
            $path = 'vendor/dashboard/image/thumbnail-tutorials/';
            if (File::exists($path . $tutorial->thumbnail)) {
                File::delete($path . $tutorial->thumbnail);
            }

            $tutorial->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Tutorial ' . $tutorial->title . ' berhasil dihapus!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Error: ' . $th->getMessage(),
            ]);
        }
    }
}
