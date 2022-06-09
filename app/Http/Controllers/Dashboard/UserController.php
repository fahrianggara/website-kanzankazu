<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user_show', ['only' => 'index']);
        $this->middleware('permission:user_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user_update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user_delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {

        $q = $request->get('keyword');

        $users = $request->get('keyword') ? User::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('email', 'LIKE', '%' . $q . '%')->paginate(10) : User::paginate(10);

        return view('dashboard.manage-users.users.index', [
            'users' => $users->appends(['keyword' => $request->keyword]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.manage-users.users.create', [
            'users' => User::all(),
        ]);
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
                'name' => 'required|alpha_spaces|max:50|min:3',
                'role' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|max:16|confirmed',
                'user_image' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
                'slug' => 'unique:users,slug'
            ],
            [
                'name.required' => 'Wajib harus diisi!',
                'name.alpha_spaces' => 'Hanya boleh huruf dan spasi!',
                'role.required' => 'Wajib harus diisi!',
                'email.required' => 'Wajib harus diisi!',
                'email.email' => 'Harus berupa alamat email!',
                'email.unique' => 'Email sudah terdaftar!',
                'password.required' => 'Wajib harus diisi!',
                'password.min' => 'Minimal 8 karakter!',
                'password.max' => 'Maksimal 16 karakter!',
                'password.confirmed' => 'Konfirmasi password tidak sama!',
                'user_image.image' => 'Harus berupa gambar!',
                'user_image.mimes' => 'Gambar harus berformat jpg, png, jpeg dan gif!',
                'user_image.max' => 'Ukuran gambar maksimal 2 MB!',
                'slug.unique' => 'Nama sudah ada!',
            ]
        );

        if ($validator->fails()) {
            $request['role'] = Role::select('id', 'name')->find($request->role);
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($validator);
        } else {
            DB::beginTransaction();
            try {
                if ($request->hasFile('user_image')) {
                    $path = public_path("vendor/dashboard/image/picture-profiles/");
                    $picture = $request->file('user_image');
                    $newPict = uniqid('USER-', true) . '.' . $picture->extension();
                    // resize
                    $resizeImg = Image::make($picture->path());
                    $resizeImg->resize(1080, 1080)->save($path . '/' . $newPict);
                }

                $user = User::create([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'user_image' => $newPict ?? "default.png",
                ]);
                $user->assignRole($request->role);

                return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
            } catch (\Throwable $th) {
                DB::rollBack();

                Alert::error(
                    'Error',
                    'Terjadi kesalahan saat menyimpan data.
                    Pesan: ' . $th->getMessage()
                );

                $request['role'] = Role::select('id', 'name')->find($request->role);
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withErrors($validator);

                return redirect()->back()->withInput($request->all());
            } finally {
                DB::commit();
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.manage-users.users.edit', [
            'user' => $user,
            'roleOld' => $user->roles->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|alpha_spaces|max:50|min:3',
                'slug'  => 'unique:users,slug,' . $user->id,
                'role' => 'required',
                'user_image' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
            ],
            [
                'name.required' => 'Wajib harus diisi!',
                'name.alpha_spaces' => 'Hanya boleh huruf dan spasi!',
                'name.max' => 'Maksimal 50 karakter!',
                'name.min' => 'Minimal 3 karakter!',
                'slug.unique' => 'Nama sudah ada!',
                'role.required' => 'Wajib harus diisi!',
                'user_image.image' => 'Harus berupa gambar!',
                'user_image.mimes' => 'Gambar harus berformat jpg, png, jpeg dan gif!',
                'user_image.max' => 'Ukuran gambar maksimal 2 MB!',
            ]
        );

        if ($validator->fails()) {
            $request['role'] = Role::select('id', 'name')->find($request->role);
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($validator);
        } else {
            DB::beginTransaction();
            try {

                if ($request->hasFile('user_image')) {
                    $path = "vendor/dashboard/image/picture-profiles/";
                    if (File::exists($path . $user->user_image)) {
                        File::delete($path . $user->user_image);
                    }
                    $userPict = $request->file('user_image');
                    $newPict = uniqid('USER-', true) . '.' . $userPict->extension();
                    // resize
                    $resizeImg = Image::make($userPict->path());
                    $resizeImg->resize(1080, 1080)->save(public_path($path) . '/' . $newPict);

                    $user->user_image = $newPict;
                }

                $user->name = $request->input('name');
                $user->slug = $request->input('slug');
                $user->syncRoles($request->role);

                $user->update();

                return redirect()->route('users.index')->with(
                    'success',
                    'Pengguna berhasil diperbarui!'
                );
            } catch (\Throwable $th) {
                DB::rollBack();

                Alert::error(
                    'Error',
                    'Terjadi kesalahan saat memperbarui data.
                    Pesan: ' . $th->getMessage()
                );

                $request['role'] = Role::select('id', 'name')->find($request->role);
                return redirect()
                    ->back()
                    ->withInput($request->all())
                    ->withErrors($validator);
            } finally {
                DB::commit();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $path = "vendor/dashboard/image/picture-profiles/";
            if (File::exists($path . $user->user_image)) {
                File::delete($path . $user->user_image);
            }
            $user->removeRole($user->roles->first());
            $user->delete();
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Terjadi kesalahan saat menghapus data.
                    Pesan: ' . $th->getMessage()
            );
        } finally {
            DB::commit();
            return redirect()->back()->with('success', 'Pengguna dengan nama' . $user->name . ' berhasil dihapus!');
        }
    }
}
