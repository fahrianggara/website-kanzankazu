<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

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
            ->orWhere('email', 'LIKE', '%' . $q . '%')->paginate(6) : User::paginate(6);

        return view('manage-users.users.index', [
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
        return view('manage-users.users.create', [
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
                'name' => 'required|string|max:50|min:3',
                'role' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'user_image' => 'required',
                'slug' => 'required'
            ],
        );

        if ($validator->fails()) {
            $request['role'] = Role::select('id', 'name')->find($request->role);
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }

        // dd($request->all());

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_image' => parse_url($request->user_image)['path'],
            ]);
            $user->assignRole($request->role);

            Alert::success('Success', 'New user created successfully');

            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Failed during data input process. 
                Message: ' . $th->getMessage()
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('manage-users.users.edit', [
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
                'name' => 'required|string|max:50|min:3',
                'slug'  => 'required|unique:users,slug,' . $user->id,
                'role' => 'required',
                'user_image' => 'required',
            ],
        );

        if ($validator->fails()) {
            $request['role'] = Role::select('id', 'name')->find($request->role);
            return redirect()
                ->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'user_image' => parse_url($request->user_image)['path'],
            ]);
            $user->syncRoles($request->role);

            Alert::success('Success', $request->name . ' user, updated successfully');

            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Failed during data input process. 
                Message: ' . $th->getMessage()
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
            $user->removeRole($user->roles->first());
            $user->delete();

            Alert::success('Success', $user->name . ' user, deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            Alert::error(
                'Error',
                'Failed during data input process. 
                Message: ' . $th->getMessage()
            );
        } finally {
            DB::commit();
            return redirect()->back();
        }
    }
}
