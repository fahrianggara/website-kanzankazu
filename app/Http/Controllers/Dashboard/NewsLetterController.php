<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;
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
