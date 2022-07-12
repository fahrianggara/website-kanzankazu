<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WebSetting;
use App\Notifications\WelcomeUserEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Contract\Database;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Spatie\Permission\Models\Role;

class FirebaseController extends Controller
{
    public function __construct(FirebaseAuth $auth)
    {
        $this->table = 'users';
        $this->setting = WebSetting::find(1);
        $this->auth = $auth;
    }

    public function redirectToGoogle(Request $request)
    {
        $checkUser = User::where('uid', $request->uid)->first();

        if ($checkUser) {
            $checkUser->uid = $request->uid;
            $checkUser->email = $request->email;
            $checkUser->update();
            Auth::loginUsingId($checkUser->id, true);

            if ($checkUser->banned_at != null) {
                if ($checkUser->banned_at == null) {
                    return response()->json([
                        "status" => 200,
                        "msg" => "Selamat datang kembali " . $checkUser->name . '.',
                        "redirect" => route('dashboard.index'),
                    ]);
                } else {
                    return response()->json([
                        "status" => 403,
                        "msg" => "Akun kamu telah di banned.",
                        "redirect" => route('login'),
                    ]);
                }
            } else {
                return response()->json([
                    "status" => 200,
                    "msg" => "Selamat datang kembali " . $checkUser->name . '.',
                    "redirect" => route('dashboard.index'),
                ]);
            }
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
                    'email_verified_at' => now(),
                    'provider' => 'google',
                ];

                $user = User::create($userData);
                $role = Role::select('id')->where('name', 'Editor')->first();
                $user->roles()->attach($role);

                $user->notify(new WelcomeUserEmail($user));
                Firebase::database()->getReference($this->table)->push($userData);

                Auth::loginUsingId($user->id, true);
                return response()->json([
                    "status" => 200,
                    "msg" => "Selamat datang di " . $this->setting->site_name . '!',
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
            if ($checkUser->banned_at != null) {
                if ($checkUser->banned_at == null) {
                    return response()->json([
                        "status" => 200,
                        "msg" => "Selamat datang kembali " . $checkUser->name . '.',
                        "redirect" => route('dashboard.index'),
                    ]);
                } else {
                    return response()->json([
                        "status" => 403,
                        "msg" => "Akun kamu telah di banned.",
                        "redirect" => route('login'),
                    ]);
                }
            } else {
                return response()->json([
                    "status" => 200,
                    "msg" => "Selamat datang kembali " . $checkUser->name . '.',
                    "redirect" => route('dashboard.index'),
                ]);
            }
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
                    'email_verified_at' => now(),
                    'provider' => 'github',
                ];

                $user = User::create($userData);
                $role = Role::select('id')->where('name', 'Editor')->first();
                $user->roles()->attach($role);

                $user->notify(new WelcomeUserEmail($user));

                Firebase::database()->getReference($this->table)->push($userData);

                Auth::loginUsingId($user->id, true);
                return response()->json([
                    "status" => 200,
                    "msg" => "Selamat datang di " . $this->setting->site_name . '!',
                    "redirect" => route('dashboard.index'),
                ]);
            }
        }
    }

    public function redirectToAnonym(Request $request)
    {
        $checkUser = User::where('uid', $request->uid)->first();
        if ($checkUser) {
            $checkUser->uid = $request->uid;

            Auth::loginUsingId($checkUser->id, true);
            if ($checkUser->banned_at != null) {
                if ($checkUser->banned_at == null) {
                    return response()->json([
                        "status" => 200,
                        "msg" => "Selamat datang kembali " . $checkUser->name . '.',
                        "redirect" => route('homepage'),
                    ]);
                } else {
                    return response()->json([
                        "status" => 403,
                        "msg" => "Akun kamu telah di banned.",
                        "redirect" => route('login'),
                    ]);
                }
            } else {
                return response()->json([
                    "status" => 200,
                    "msg" => "Selamat datang kembali " . $checkUser->name . '.',
                    "redirect" => route('homepage'),
                ]);
            }
        } else {
            $randomStr = 'Anonymous ' . Str::random(3);
            $userData = [
                'uid' => $request->uid,
                'name' => $randomStr,
                'slug' => Str::slug($randomStr),
                'email_verified_at' => now(),
                'provider' => 'anonymous',
            ];

            $user = User::create($userData);
            $role = Role::select('id')->where('name', 'Editor')->first();
            $user->roles()->attach($role);

            Firebase::database()->getReference($this->table)->push($userData);

            Auth::loginUsingId($user->id, true);
            return response()->json([
                "status" => 200,
                "msg" => "Selamat datang di " . $this->setting->site_name . '!',
                "redirect" => route('homepage'),
            ]);
        }
    }
}
