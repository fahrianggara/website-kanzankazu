<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
                'description'   => 'nullable|max:400|min:5'
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
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        } else {

            try {
                if ($request->hasFile('thumbnail')) {
                    // $public_path = '../../public_html/blog/';
                    // $path = $public_path . "vendor/dashboard/image/thumbnail-tutorials/";
                    $path = 'vendor/dashboard/image/thumbnail-tutorials/';
                    $image = $request->file('thumbnail');
                    $newImage = uniqid('TutorIMG-') . '.' . $image->extension();
                    // Resize
                    $resizeImg = Image::make($image->path());
                    $resizeImg->resize(1280, 800)->save($path . '/' . $newImage);
                }

                $insert = Tutorial::create([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'thumbnail' => $newImage,
                ]);

                return redirect()->route('tutorials.index')->with('success', 'Tutorial baru berhasil ditambahkan');
            } catch (\Throwable $th) {
                Alert::error(
                    'Error',
                    'Terjadi kesalahan saat menyimpan data.
                    Pesan: ' . $th->getMessage()
                );
                return redirect()->back()->withInput($request->all());
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function edit(Tutorial $tutorial)
    {
        return view('dashboard.manage-posts.tutorials.edit', compact('tutorial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tutorial $tutorial)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title'         => 'required|string|max:20|min:3',
                'slug'          => 'unique:tutorials,slug,' . $tutorial->id,
                'thumbnail'     => 'image|mimes:jpg,png,jpeg,gif|max:1024',
                'description'   => 'nullable|max:400|min:5'
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
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        } else {
            try {
                $tutorial->title = $request->title;
                $tutorial->slug = $request->slug;
                $tutorial->description = $request->description;

                if ($request->hasFile('thumbnail')) {
                    // $public_path = '../../public_html/blog/';
                    // $path = $public_path . "vendor/dashboard/image/thumbnail-tutorials/";
                    $path = 'vendor/dashboard/image/thumbnail-tutorials/';
                    if (File::exists($path . $tutorial->thumbnail)) {
                        File::delete($path . $tutorial->thumbnail);
                    }
                    $image = $request->file('thumbnail');
                    $newImage = uniqid('TutorIMG-') . '.' . $image->extension();
                    // Resize
                    $resizeImg = Image::make($image->path());
                    $resizeImg->resize(1280, 800)->save($path . '/' . $newImage);

                    $tutorial->thumbnail = $newImage;
                }

                if ($tutorial->isDirty()) {

                    $tutorial->update();

                    return redirect()->route('tutorials.index')
                        ->with('success', 'Tutorial ' . $tutorial->title . ' berhasil diperbarui');
                } else {
                    return redirect()->route('tutorials.index')
                        ->with('success', 'Tidak ada perubahan');
                }
            } catch (\Throwable $th) {
                Alert::error(
                    'Error',
                    'Terjadi kesalahan saat memperbarui data.
                    Pesan: ' . $th->getMessage()
                );
                return redirect()->back()->withInput($request->all());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tutorial $tutorial)
    {
        try {
            // $public_path = '../../public_html/blog/';
            // $path = $public_path . "vendor/dashboard/image/thumbnail-tutorials/";
            $path = 'vendor/dashboard/image/thumbnail-tutorials/';
            if (File::exists($path . $tutorial->thumbnail)) {
                File::delete($path . $tutorial->thumbnail);
            }

            $tutorial->delete();
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Terjadi kesalahan saat menghapus data.
                Pesan: ' . $th->getMessage()
            );
        }

        return redirect()->route('tutorials.index')
            ->with('success', 'Tutorial ' . $tutorial->title . ' berhasil dihapus');
    }
}
