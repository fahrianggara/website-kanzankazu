<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
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

        return view('manage-users.roles.index', [
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
        return view('manage-users.roles.create', [
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
                "name" => "required|string|max:100|unique:roles,name",
                "permissions" => "required",
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $request->name]);
            $role->givePermissionTo($request->permissions);

            Alert::success('Success', 'New role permission, created successfully');

            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Failed during data input process. 
                Message: ' . $th->getMessage()
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
        return view('manage-users.roles.detail', [
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
        return view('manage-users.roles.edit', [
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
                "name" => "required|string|max:100|unique:roles,name," . $role->id,
                "permissions" => "required",
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

            Alert::success('Success', $request->name . ' role, updated successfully');

            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Failed during data input process. 
                Message: ' . $th->getMessage()
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
                "Sorry, the " . $role->name . " role cannot be deleted. Because it's still in use."
            );
            return redirect()->route('roles.index');
        }

        DB::beginTransaction();
        try {
            $role->revokePermissionTo($role->permissions->pluck('name')->toArray());
            $role->delete();

            Alert::success('Success', $role->name . ' role, updated successfully');

            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Failed during data input process. 
                Message: ' . $th->getMessage()
            );
        } finally {
            DB::commit();
        }
        return redirect()->route('roles.index');
    }
}
