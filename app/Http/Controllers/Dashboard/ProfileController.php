<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Database;

class ProfileController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->table = 'users';

        $this->setting = WebSetting::find(1);
    }

    public function index()
    {
        return view('dashboard.manage-users.profiles.index');
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|alpha_spaces|min:3|max:20',
                'bio'  => 'nullable|min:10|max:500',
                'slug' => 'string|unique:users,slug,' . Auth::user()->id,
                'facebook' => 'nullable|url_www',
                'twitter'  => 'nullable|url_www',
                'instagram' => 'nullable|url_www',
                'github'  => 'nullable|url_www',
            ],
            [
                'name.required' => 'Masukkan nama kamu',
                'name.alpha_spaces' => 'Hanya boleh berisi huruf dan spasi',
                'name.min' => 'Minimal 3 karakter',
                'name.max' => 'Maksimal 20 karakter',
                'bio.min' => 'Minimal 10 karakter',
                'bio.max' => 'Maksimal 500 karakter',
                'slug.unique' => 'Username ini sudah digunakan',
                'facebook.url_www' => 'URL tidak valid',
                'twitter.url_www'  => 'URL tidak valid',
                'instagram.url_www' => 'URL tidak valid',
                'github.url_www'  => 'URL tidak valid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'  => 400,
                'errors'  => $validator->errors()->toArray(),
            ]);
        } else {
            $query = User::find(Auth::user()->id);
            $key = $query->uid;

            if ($query) {

                $query->name  = $request->input('name');
                $query->bio   = $request->input('bio');
                $query->slug  = $request->slug;
                $query->facebook = $request->input('facebook');
                $query->twitter  = $request->input('twitter');
                $query->instagram = $request->input('instagram');
                $query->github  = $request->input('github');

                if ($key != null) {
                    $this->database->getReference($this->table . '/' . $key)->update($query->toArray());
                }

                if ($query->isDirty()) {
                    $query->update();

                    return response()->json([
                        'status' => 200,
                        'msg'    => 'Profile kamu berhasil diperbarui!',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'msg'    => "Oops.. tidak ada perubahan",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'msg'    => "Data kamu tidak ditemukan",
                ]);
            }
        }
    }

    public function updateImage(Request $request)
    {
        $path = 'vendor/dashboard/image/picture-profiles/';
        $file = $request->file('user_image');
        $new_name = uniqid("USER-", true) . ".jpg";

        $upload = $file->move($path, $new_name);
        $user = User::find(Auth::user()->id);

        if (!$upload) {
            return response()->json([
                "status" => 0,
                "msg"    => "Oops.. terjadi kesalahan saat menyimpan foto profile kamu."
            ]);
        } else {

            $oldPicture = $user->getAttributes()['user_image'];

            if ($oldPicture != '') {
                if (File::exists($path . $oldPicture)) {
                    File::delete($path . $oldPicture);
                }
            }

            $updateImageProfile = $user->update([
                'user_image' => $new_name
            ]);

            $uid = $user->uid;
            if ($uid != null) {
                $this->database->getReference($this->table . '/' . $uid)->set($user->toArray());
            }


            if (!$updateImageProfile) {
                return response()->json([
                    "status" => 0,
                    "msg"    => "Oops.. terjadi kesalahan saat memperbarui foto profile kamu."
                ]);
            } else {
                return response()->json([
                    "status" => 1,
                    "msg"    => "Foto profile kamu berhasil diperbarui."
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
            'oldpass.required' => 'Masukkan password yang sekarang',
            'oldpass.min'      => 'Minimal 8 karakter',
            'oldpass.max'      => 'Maksimal 16 karakter',
            'newpass.required' => 'Masukkan password baru',
            'newpass.min'      => 'Minimal 8 karakter',
            'newpass.max'      => 'Maksimal 16 karakter',
            'confirmpass.required' => 'Masukkan konfirmasi password',
            'confirmpass.min'      => 'Minimal 8 karakter',
            'confirmpass.max'      => 'Maksimal 16 karakter',
            'confirmpass.same'     => 'Konfirmasi password harus sama dengan password baru',
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
                        'msg'    => 'Password kamu berhasil diperbarui!',
                    ]);
                } else {
                    return response()->json([
                        'status' => 200,
                        'msg'    => "Oops.. tidak ada perubahan!",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'msg'    => "Data kamu tidak ditemukan",
                ]);
            }
        }
    }
}
