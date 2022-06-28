<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class NewsLetterController extends Controller
{
    public function index(Request $request)
    {
        if ($request->keyword) {
            $newsletter = Newsletter::where('email', 'like', '%' . $request->keyword . '%')->paginate(10);
        } else {
            $newsletter = Newsletter::paginate(10);
        }
        return view('dashboard.contact.newsletter.index', compact('newsletter'));
    }

    function storeEmail(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:newsletters,email'
            ],
            [
                'email.required' => 'Masukkan alamat email kamu',
                'email.email' => 'Alamat email kamu tidak valid',
                'email.unique' => 'Alamat email ini sudah berlangganan diwebsite kami'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->errors()->toArray(),
            ]);
        } else {
            $query = Newsletter::create(['email' => $request->email]);

            if ($query) {
                return response()->json([
                    'status' => 200,
                    'msg'    => 'Terima kasih telah berlangganan di website kami',
                ]);
            }
        }
    }

    public function destroy(Newsletter $newsletter)
    {
        try {
            $newsletter->delete();
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Terjadi kesalahan saat menghapus data.
                Pesan: ' . $th->getMessage()
            )->autoClose(false);
        }

        return redirect()->back()->with('success', 'Langganan website dengan email ' . $newsletter->email . ' berhasil diberhentikan!');
    }
}
