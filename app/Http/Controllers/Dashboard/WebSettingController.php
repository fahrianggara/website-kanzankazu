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
                'site_name' => 'required|string|max:15|min:3',
                'site_description' => 'required|string|max:200|min:10',
                'site_footer' => 'required|string|max:30|min:3',
                'site_email' => 'required|email',
                'meta_keywords' => 'nullable|string|max:100|min:3',
                'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'link_github' => 'nullable|url',
                'link_twitter' => 'nullable|url',
            ],
            [
                'site_name.required' => 'Site Name is required',
                'site_name.max' => 'Site Name must be less than 15 characters',
                'site_name.min' => 'Site Name must be more than 3 characters',
                'site_description.required' => 'Site Description is required',
                'site_description.max' => 'Site Description must be less than 200 characters',
                'site_description.min' => 'Site Description must be more than 10 characters',
                'site_footer.required' => 'Site Footer is required',
                'site_footer.max' => 'Site Footer must be less than 30 characters',
                'site_footer.min' => 'Site Footer must be more than 3 characters',
                'site_email.required' => 'Site Email is required',
                'site_email.email' => 'Site Email must be a valid email',
                'site_email.unique' => 'Site Email must be unique',
                'meta_keywords.max' => 'Meta Keywords must be less than 100 characters',
                'meta_keywords.min' => 'Meta Keywords must be more than 3 characters',
                'image_banner.required' => 'Image Banner is required',
                'image_banner.image' => 'Image Banner must be an image',
                'image_banner.mimes' => 'Image Banner must be a file of type: jpeg, png, jpg, gif, svg',
                'image_banner.max' => 'Image Banner must be less than 2048 kilobytes',
                'link_github.url' => 'Link Github must be a valid URL',
                'link_twitter.url' => 'Link Twitter must be a valid URL',
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
                    $path = "vendor/blog/img/home-img/";
                    if (File::exists($path . $webSetting->image_banner)) {
                        File::delete($path . $webSetting->image_banner);
                    }
                    $image = $request->file('image_banner');
                    $newImage = uniqid('BANNER-', true) . '.' . $image->extension();
                    $image->move(public_path($path), $newImage);
                    $webSetting->image_banner = $newImage;
                }

                if ($webSetting->isDirty()) {

                    $webSetting->update();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Site has been updated',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Nothing to update',
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
                    $path = "vendor/blog/img/home-img/";
                    $image = $request->file('image_banner');
                    $newImage = uniqid('BANNER-', true) . '.' . $image->extension();
                    $image->move(public_path($path), $newImage);
                    $webSetting->image_banner = $newImage;
                }

                if ($webSetting->isDirty()) {

                    $webSetting->save();

                    return response()->json([
                        'status' => 200,
                        'message' => 'Site has been added',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Nothing to update',
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
