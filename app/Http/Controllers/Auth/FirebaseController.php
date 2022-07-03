<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Database;
use Spatie\Permission\Models\Role;

class FirebaseController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->table = 'users';

        $this->setting = WebSetting::find(1);
    }

    public function redirectToGoogle(Request $request)
    {
        $checkUser = User::where('uid', $request->uid)->firstOrFail();

        if ($checkUser) {
            $checkUser->uid = $request->uid;
            $checkUser->email = $request->email;
            $checkUser->update();
            Auth::loginUsingId($checkUser->id, true);
            return response()->json([
                "status" => 200,
                "msg" => "Selamat datang kembali " . $checkUser->name . '.',
                "redirect" => route('dashboard.index'),
            ]);
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|unique:users',
                ],
                [
                    'email.unique' => 'Email ini sudah terdaftar sebelum menggunakan login dengan google.',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    "status" => 400,
                    "error" => $validator->errors()->toArray(),
                ]);
            } else {
                $userData = [
                    'uid' => $request->uid,
                    'name' => $request->name,
                    'slug' => Str::slug($request->name) . '-' . strtolower(Str::random(3)),
                    'user_image' => $request->user_image,
                    'email' => $request->email,
                    'password' => bcrypt($request->uid),
                    'email_verified_at' => now(),
                    'provider' => 'google',
                ];

                $user = User::create($userData);
                $role = Role::select('id')->where('name', 'Editor')->first();
                $user->roles()->attach($role);

                $toFirebaseDB = [
                    $this->table . '/' . $request->uid => $userData,
                ];
                $this->database->getReference()->update($toFirebaseDB);

                Auth::loginUsingId($user->id, true);
                return response()->json([
                    "status" => 200,
                    "msg" => "Selamat datang di " . $this->setting->site_name . '! ' . $request->name . '.',
                    "redirect" => route('dashboard.index'),
                ]);
            }
        }
    }

    public function redirectToGithub(Request $request)
    {
        $checkUser = User::where('uid', $request->uid)->first();

        if ($checkUser) {
            $checkUser->uid = $request->uid;
            $checkUser->email = $request->email;
            $checkUser->update();
            Auth::loginUsingId($checkUser->id, true);
            return response()->json([
                "status" => 200,
                "msg" => "Selamat datang kembali " . $checkUser->name . '.',
                "redirect" => route('dashboard.index'),
            ]);
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|unique:users',
                ],
                [
                    'email.unique' => 'Email ini sudah terdaftar sebelum menggunakan login dengan github.',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    "status" => 400,
                    "error" => $validator->errors()->toArray(),
                ]);
            } else {
                $siteName = "KZN";
                $userData = [
                    'uid' => $request->uid,
                    'name' => $request->name ?? $siteName,
                    'slug' => Str::slug($request->name ?? $siteName) . '-' . strtolower(Str::random(3)),
                    'user_image' => $request->user_image,
                    'email' => $request->email,
                    'password' => bcrypt($request->uid),
                    'email_verified_at' => now(),
                    'provider' => 'github',
                ];

                $user = User::create($userData);
                $role = Role::select('id')->where('name', 'Editor')->first();
                $user->roles()->attach($role);

                $toFirebaseDB = [
                    $this->table . '/' . $request->uid => $userData,
                ];
                $this->database->getReference()->update($toFirebaseDB);

                Auth::loginUsingId($user->id, true);
                return response()->json([
                    "status" => 200,
                    "msg" => "Selamat datang di " . $this->setting->site_name . '! ' . $request->name ?? $siteName . '.',
                    "redirect" => route('dashboard.index'),
                ]);
            }
        }
    }
}
