<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\WebSetting;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;


class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user_show', ['only' => 'index']);
        $this->middleware('permission:user_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user_update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user_detail', ['only' => 'show']);
        $this->middleware('permission:user_delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = [];
        if ($request->has('keyword')) {
            $roles = Role::where('name', 'LIKE', "%{$request->keyword}%")->paginate(5);
        } else {
            $roles = Role::paginate(5);
        }

        return view('dashboard.manage-users.roles.index', [
            'roles' => $roles->appends(['keyword' => $request->keyword]),
        ]);
    }

    public function select(Request $request)
    {
        $roles = Role::select('id', 'name')->limit(7);
        if ($request->has('q')) {
            $roles->where('name', 'LIKE', "%{$request->q}%");
        }
        return response()->json($roles->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.manage-users.roles.create', [
            'authorities' => config('permission.authorities'),
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
                "name" => "required|alpha_spaces|max:100|min:3|unique:roles,name",
                "permissions" => "required",
            ],
            [
                "name.required" => "Wajib harus diisi",
                "name.alpha_spaces" => "Hanya boleh berisi huruf dan spasi",
                "name.max" => "Maksimal 100 karakter",
                "name.min" => "Minimal 3 karakter",
                "name.unique" => "Role ini sudah digunakan",
                "permissions.required" => "Wajib harus diisi",
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $request->name]);
            $role->givePermissionTo($request->permissions);

            // Alert::success('Success', 'New role permission, created successfully');

            return redirect()->route('roles.index')->with('success', 'Role baru berhasil ditambahkan!');
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Terjadi kesalahan saat menyimpan data.
                Pesan: ' . $th->getMessage()
            );

            return redirect()->back()->withInput($request->all());
        } finally {
            DB::commit();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('dashboard.manage-users.roles.detail', [
            'role' => $role,
            'authorities' => config('permission.authorities'),
            'rolePermissions' => $role->permissions->pluck('name')->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('dashboard.manage-users.roles.edit', [
            'role' => $role,
            'authorities' => config('permission.authorities'),
            'permissionChecked' => $role->permissions->pluck('name')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => "required|alpha_spaces|max:100|min:3|unique:roles,name," . $role->id,
                "permissions" => "required",
            ],
            [
                "name.required" => "Wajib harus diisi",
                "name.alpha_spaces" => "Hanya boleh berisi huruf dan spasi",
                "name.max" => "Maksimal 100 karakter",
                "name.min" => "Minimal 3 karakter",
                "name.unique" => "Role ini sudah digunakan",
                "permissions.required" => "Wajib harus diisi",
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $role->name = $request->name;
            $role->syncPermissions($request->permissions);
            $role->update();

            return redirect()->route('roles.index')
                ->with(
                    'success',
                    'Role ' . $request->name . ' berhasil diperbarui!'
                );
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Terjadi kesalahan saat memperbarui data.
                    Pesan: ' . $th->getMessage()
            );

            return redirect()->back()->withInput($request->all());
        } finally {
            DB::commit();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (User::role($role->name)->count()) {
            Alert::warning(
                'Warning',
                "Oops.. role " . $role->name . " tidak bisa hapus, karena role ini sedang digunakan."
            );
            return redirect()->route('roles.index');
        }

        DB::beginTransaction();
        try {
            $role->revokePermissionTo($role->permissions->pluck('name')->toArray());
            $role->delete();

            // Alert::success('Success', $role->name . ' role, updated successfully');

            return redirect()->route('roles.index')
                ->with(
                    'success',
                    'Role ' . $role->name . ' berhasil dihapus!'
                );
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Terjadi kesalahan saat menghapus data.
                    Pesan: ' . $th->getMessage()
            );
        } finally {
            DB::commit();
        }
        return redirect()->route('roles.index')->with('success', 'Gagal saat menghapus role!');
    }
}
