<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class WebSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.manage-webs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSite(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'site_name' => 'required|alpha_spaces|max:15|min:3',
                'site_description' => 'required|string|max:200|min:10',
                'site_footer' => 'required|string|max:30|min:3',
                'site_email' => 'required|email',
                'meta_keywords' => 'nullable|min:3',
                'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                'link_github' => 'nullable|url',
                'link_twitter' => 'nullable|url',
            ],
            [
                'site_name.required' => 'Wajib harus diisi',
                'site_name.alpha_spaces' => 'Hanya boleh huruf dan spasi',
                'site_name.max' => 'Maksimal 15 karakter',
                'site_name.min' => 'Minimal 3 karakter',
                'site_description.required' => 'Wajib harus diisi',
                'site_description.max' => 'Maksimal 200 karakter',
                'site_description.min' => 'Minimal 10 karakter',
                'site_footer.required' => 'Wajib harus diisi',
                'site_footer.max' => 'Maksimal 30 karakter',
                'site_footer.min' => 'Minimal 3 karakter',
                'site_email.required' => 'Wajib harus diisi',
                'site_email.email' => 'Email tidak valid',
                'site_email.unique' => 'Email sudah digunakan',
                'meta_keywords.min' => 'Minimal 3 karakter',
                'image_banner.required' => 'Wajib harus diisi',
                'image_banner.image' => 'File harus berupa gambar',
                'image_banner.mimes' => 'Gambar harus berformat: jpeg, png, jpg, gif dan svg',
                'image_banner.max' => 'Ukuran gambar maksimal 1 MB',
                'link_github.url' => 'Url tidak valid',
                'link_twitter.url' => 'Url tidak valid',
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray(),
            ]);
        } else {
            $webSetting = WebSetting::where('id', 1)->first();

            if ($webSetting) {

                $webSetting->site_name = $request->site_name;
                $webSetting->site_description = $request->site_description;
                $webSetting->site_footer = $request->site_footer;
                $webSetting->site_email = $request->site_email;
                $webSetting->meta_keywords = $request->meta_keywords;
                $webSetting->site_github = $request->link_github;
                $webSetting->site_twitter = $request->link_twitter;

                if ($request->hasFile('image_banner')) {
                    // $public_path = '../../public_html/blog/';
                    // $path = $public_path . "vendor/blog/img/home-img/";
                    $path =  "vendor/blog/img/home-img/";
                    if (File::exists($path . $webSetting->image_banner)) {
                        File::delete($path . $webSetting->image_banner);
                    }
                    $image = $request->file('image_banner');
                    $newImage = uniqid('BANNER-', true) . '.' . $image->extension();
                    $image->move($path, $newImage);
                    $webSetting->image_banner = $newImage;
                }

                if ($webSetting->isDirty()) {

                    $webSetting->update();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Website berhasil diperbarui',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Tidak ada yang dirubah',
                    ]);
                }
            } else {

                $webSetting = new WebSetting;

                $webSetting->site_name = $request->site_name;
                $webSetting->site_description = $request->site_description;
                $webSetting->site_footer = $request->site_footer;
                $webSetting->site_email = $request->site_email;
                $webSetting->meta_keywords = $request->meta_keywords;
                $webSetting->site_github = $request->link_github;
                $webSetting->site_twitter = $request->link_twitter;

                if ($request->hasFile('image_banner')) {
                    // $public_path = '../../public_html/blog/';
                    // $path = $public_path . "vendor/blog/img/home-img/";
                    $path = "vendor/blog/img/home-img/";
                    $image = $request->file('image_banner');
                    $newImage = uniqid('BANNER-', true) . '.' . $image->extension();
                    $image->move($path, $newImage);
                    $webSetting->image_banner = $newImage;
                }

                if ($webSetting->isDirty()) {

                    $webSetting->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Data website berhasil ditambahkan',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Tidak ada yang dirubah',
                    ]);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WebSetting  $webSetting
     * @return \Illuminate\Http\Response
     */
    public function show(WebSetting $webSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WebSetting  $webSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(WebSetting $webSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WebSetting  $webSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WebSetting $webSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WebSetting  $webSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(WebSetting $webSetting)
    {
        //
    }
}
