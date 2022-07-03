<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\WebSetting;
use App\Notifications\WelcomeUserEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Contract\Database;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Database $database)
    {
        $this->middleware('guest');

        $this->database = $database;
        $this->table = 'users';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => ['required', 'alpha_spaces', 'string', 'max:12', 'min:3', 'unique:users,slug'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
            ],
            [
                'name.unique' => 'Nama ini sudah digunakan',
                'name.max' => 'Maksimal 12 huruf',
                'name.min' => 'Minimal 3 huruf',
                'email.unique' => 'Email ini sudah digunakan',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $userData = [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        $user = User::create($userData);
        $role = Role::select('id')->where('name', 'Editor')->first();
        $user->roles()->attach($role);

        $this->database->getReference($this->table)->push($userData);

        $user->notify(new WelcomeUserEmail($user));

        return $user;
    }
}
