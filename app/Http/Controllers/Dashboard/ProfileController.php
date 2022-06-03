<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    public function index()
    {
        $setting = WebSetting::find(1);
        View::share('setting', $setting);

        return view('dashboard.manage-users.profiles.index');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha_spaces|min:3|max:8',
            'bio'  => 'nullable|min:10|max:500',
            'slug' => 'string|unique:users,slug,' . Auth::user()->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->toArray(),
            ]);
        } else {
            $query = User::find(Auth::user()->id);

            if ($query) {
                $query->name  = $request->input('name');
                $query->bio   = $request->input('bio');
                $query->slug  = $request->input('slug');

                if ($query->isDirty()) {
                    $query->update();

                    return response()->json([
                        'status' => 200,
                        'msg'    => 'Your Profile Info has been updated!',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'msg'    => "Oops.. nothing seems to be updated!",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'msg'    => "Your data not found!"
                ]);
            }
        }
    }

    public function updateImage(Request $request)
    {
        $public_path = '../../public_html/blog/';
        $path = 'vendor/dashboard/image/picture-profiles/';
        $file = $request->file('user_image');
        // $ext = $file->getClientOriginalExtension();
        $new_name = uniqid("USER-", true) . ".jpg";

        $upload = $file->move(public_path($path), $new_name);

        if (!$upload) {
            return response()->json([
                "status" => 0,
                "msg"    => "Oops.. something went wrong, upload new picture failed."
            ]);
        } else {
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['user_image'];

            if ($oldPicture != '') {
                if (File::exists(public_path($path . $oldPicture))) {
                    File::delete(public_path($path . $oldPicture));
                }
            }

            $updateImageProfile = User::find(Auth::user()->id)->update([
                'user_image' => $new_name
            ]);

            if (!$updateImageProfile) {
                return response()->json([
                    "status" => 0,
                    "msg"    => "Oops.. something went wrong, updating your picture."
                ]);
            } else {
                return response()->json([
                    "status" => 1,
                    "msg"    => "Your Picture Profile has been updated."
                ]);
            }
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpass' => [
                'required',
                'string',
                'min:8',
                'max:16',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('The current password is incorrect.');
                    }
                },
            ],
            'newpass' => [
                'required',
                'string',
                'min:8',
                'max:16',
            ],
            'confirmpass' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'same:newpass',
            ],
        ], [
            'oldpass.required' => 'Enter your current password.',
            'oldpass.min'      => 'Your current password must be at least 8 characters.',
            'oldpass.max'      => 'Your current password must be at most 16 characters.',
            'newpass.required' => 'Enter your new password.',
            'newpass.min'      => 'Your current password must be at least 8 characters.',
            'newpass.max'      => 'Your current password must be at most 16 characters.',
            'confirmpass.required' => 'Enter your confirm password.',
            'confirmpass.min'      => 'Your current password must be at least 8 characters.',
            'confirmpass.max'      => 'Your current password must be at most 16 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->toArray(),
            ]);
        } else {
            $query = User::find(Auth::user()->id);

            if ($query) {
                $query->password = Hash::make($request->input('newpass'));

                if ($query->isDirty()) {
                    $query->update();

                    return response()->json([
                        'status' => 200,
                        'msg'    => 'Your Password has been updated!',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'msg'    => "Oops.. nothing seems to be updated!",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'msg'    => "Your data not found!"
                ]);
            }
        }
    }

    public function updateSocial(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'facebook' => 'nullable|url_www',
            'twitter'  => 'nullable|url_www',
            'instagram' => 'nullable|url_www',
            'github'  => 'nullable|url_www',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->toArray(),
            ]);
        } else {
            $query = User::find(Auth::user()->id);

            if ($query) {
                $query->facebook = $request->input('facebook');
                $query->twitter  = $request->input('twitter');
                $query->instagram = $request->input('instagram');
                $query->github  = $request->input('github');

                if ($query->isDirty()) {
                    $query->update();

                    return response()->json([
                        'status' => 200,
                        'msg'    => 'Your Social Media has been updated!',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'msg'    => "Oops.. nothing seems to be updated!",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'msg'    => "Your data not found!"
                ]);
            }
        }
    }
}
