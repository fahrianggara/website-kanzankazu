<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Factory;
use Kreait\Laravel\Firebase\Facades\Firebase;
use RealRashid\SweetAlert\Facades\Alert;

class UserProviderController extends Controller
{
    public function __construct(Database $database, Auth $auth)
    {
        $this->auth = $auth;
        $this->table = 'users';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = Firebase::database()->getReference($this->table)->getValue();
        $users = $this->auth->listUsers();
        return view('dashboard.firebase.authentication.index', compact('users'));
    }

    public function disableProvider($uid)
    {
        $this->auth->disableUser($uid);
        return redirect()->back()->with('success', 'Akun berhasil di disable');
    }

    public function enableProvider($uid)
    {
        $this->auth->enableUser($uid);
        return redirect()->back()->with('success', 'Akun berhasil di enable');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProvider($uid)
    {
        try {
            $user = User::where('uid', $uid)->first();
            if ($user == null) {
                $this->auth->deleteUser($uid);
            } else {
                $path = "vendor/dashboard/image/picture-profiles/";
                if (File::exists($path . $user->user_image)) {
                    File::delete($path . $user->user_image);
                }
                $user->comments()->delete();
                $user->roles()->detach();
                $user->delete();

                $this->auth->deleteUser($uid);
            }
            return redirect()->back()->with('success', 'Akun berhasil di hapus');
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Terjadi kesalahan saat menghapus data.
                    Pesan: ' . $th->getMessage()
            )->autoClose(false);
            return redirect()->back()->with('success', 'Hmm.. Sepertinya ada kesalahan');
        }
    }
}
