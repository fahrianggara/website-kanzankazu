<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

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

    public function fetch()
    {
        $tags = Tag::all();
        $output = '';

        if ($tags->count() > 0) {
            $output .= '
            <table id="tableTag" class="table table-hover align-items-center overflow-hidden">
                <thead>
                    <tr>
                        <th>Nama Tag</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
           ';
            foreach ($tags as $tag) {
                $output .= '
                    <tr>
                        <td> ' . $tag->title . ' </td>

                        <td>
                            <div class="btn-group dropleft">
                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </button>

                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-1">
                                    <button value="' . $tag->id . '" class="edit_btn dropdown-item d-flex align-items-center">
                                        <i class="uil uil-pen text-warning"></i>
                                        <span class="ml-2">Edit Tag</span>
                                    </button>
                                    <button value="' . $tag->id . '" data-name="' . $tag->title . '" class="del_btn dropdown-item d-flex align-items-center">
                                        <i class="uil uil-trash text-danger"></i>
                                        <span class="ml-2">Hapus Tag</span>
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
                        <b>
                            @if (request()->get("keyword"))
                                Oops.. sepertinya tag {{ strtoupper(request()->get("keyword")) }}
                                tidak ditemukan.
                            @else
                                Hmm.. sepertinya belum ada tag yang dibuat. <a
                                    href="{{ route("tags.create") }}#posts">Buat?</a>
                            @endif
                        </b>
                    </p>
                </div>
            </div>
            ';
        }
        echo $output;
    }

    // SELECT
    public function select(Request $request)
    {
        $tags = [];
        if ($request->has('q')) {
            $tags = Tag::select('id', 'title')->search($request->q)->get();
        } else {
            $tags = Tag::select('id', 'title')->get();
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|alpha_spaces|max:15|min:3',
            'slug' => 'unique:tags,slug',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray()
            ]);
        } else {
            try {
                $tag = Tag::create([
                    'title' => $request->input('title'),
                    'slug' =>  $request->input('slug'),
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Tag postingan berhasil ditambahkan",
                ]);
            } catch (\Throwable $th) {
                Alert::error(
                    'Error',
                    'Terjadi kesalahan saat menyimpan data.
                Pesan: ' . $th->getMessage()
                )->autoClose(false);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);

        if ($tag) {
            return response()->json([
                'status' => 200,
                'data' => $tag
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Data tag tidak ditemukan'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|alpha_spaces|max:15|min:3',
            'slug' => 'unique:tags,slug,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray()
            ]);
        } else {

            try {
                $tag = Tag::find($id);
                if ($tag) {

                    $tag->title = $request->input('title');
                    $tag->slug = $request->input('slug');

                    if ($tag->isDirty()) {

                        $tag->update();

                        return response()->json([
                            'status' => 200,
                            'message' => "Tag postingan " . $tag->title . " berhasil diubah",
                        ]);
                    } else {
                        return response()->json([
                            'status' => 401,
                            'message' => "Tidak ada perubahan"
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 405,
                        'message' => 'tidak ada data tag'
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 405,
                    'message' => 'Pesan: ' . $th->getMessage()
                ]);
            }
        }

        // Validator::make(
        //     $request->all(),
        //     [
        //         'title'         => 'required|alpha_spaces|max:50|min:3',
        //         'slug'          => 'unique:tags,slug,' . $tag->id,
        //     ],
        //     [
        //         'title.required'         => 'Wajib harus diisi!',
        //         'title.alpha_spaces'     => 'Hanya boleh huruf dan spasi!',
        //         'title.max'              => 'Maksimal 50 karakter!',
        //         'title.min'              => 'Minimal 3 karakter!',
        //         'slug.unique'            => 'Tag sudah ada!',
        //     ],
        // )->validate();

        // try {
        //     $tag->title = $request->input('title');
        //     $tag->slug  = $request->input('slug');

        //     if ($tag->isDirty()) {

        //         $tag->update();

        //         return redirect()->route('tags.index')
        //             ->with(
        //                 'success',
        //                 'Tag berhasil diperbarui!'
        //             );
        //     } else {
        //         return redirect()->route('tags.index')
        //             ->with(
        //                 'success',
        //                 'Oops.. tidak ada perubahan!'
        //             );
        //     }
        // } catch (\Throwable $th) {
        //     Alert::error(
        //         'Error',
        //         'Terjadi kesalahan saat memperbarui data.
        //         Pesan: ' . $th->getMessage()
        //     )->autoClose(false);

        //     return redirect()->back()->withInput($request->all());
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);

        if ($tag) {

            $usePostTag = Post::join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                ->where('post_tag.tag_id', $tag->id)->get();

            if ($usePostTag->count() >= 1) {
                // Alert::warning(
                //     'Warning',
                //     "Oops.. tag " . $tag->title . " tidak bisa hapus, karena tag ini sedang digunakan."
                // )->autoClose(false);

                return response()->json([
                    'status' => 405,
                    'message' => "Tag " . $tag->title . " tidak bisa dihapus, karena tag ini sedang digunakan."
                ]);
            }

            $tag->delete();

            return response()->json([
                'status' => 200,
                'message' => "Tag " . $tag->title . " berhasil dihapus",
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Data employee not found!"
            ]);
        }
    }
}
