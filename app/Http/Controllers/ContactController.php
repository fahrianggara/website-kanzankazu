<?php

namespace App\Http\Controllers;

use App\Mail\ReplayInbox;
use App\Models\Contact;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    public function __construct()
    {
        $setting = WebSetting::find(1);
        View::share('setting', $setting);

        $this->middleware('permission:inbox_show', ['only' => 'index']);
        $this->middleware('permission:inbox_delete', ['only' => 'destroy']);
    }

    public function index(Request $request)
    {
        if (in_array($request->input('status'), ['unanswered', 'answered'])) {
            $statusSelected = $request->get('status');
        } else {
            $statusSelected = 'unanswered';
        }

        if ($statusSelected == 'unanswered') {
            $contacts = Contact::unanswered()->latest();
        } else if ($statusSelected == 'answered') {
            $contacts = Contact::answered()->latest();
        }

        if ($request->keyword) {
            $contacts->search($request->keyword)->latest();
        }

        return view('dashboard.contact.index', [
            'contacts' => $contacts->paginate(20)->withQueryString(),
            'statusSelected' => $statusSelected,
        ]);
    }

    function save(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|alpha_spaces|min:3|max:40',
                "email" => 'required|email',
                'subject' => 'required|string|alpha_spaces|max:50|min:3',
                'messages' => 'required|max:300|min:5',
            ],
            [
                'name.required' => 'Masukkan nama kamu',
                'name.alpha_spaces' => 'Input nama tidak boleh mengandung angka dan lain-lain',
                'name.min' => 'Input nama minimal 3 karakter',
                'name.max' => 'Input nama maksimal 40 karakter',
                'email.required' => 'Masukkan alamat email kamu',
                'email.email' => 'Email kamu tidak valid',
                'subject.required' => 'Masukkan judul pesan kamu',
                'subject.alpha_spaces' => 'Judul pesan tidak boleh mengandung angka dan lain-lain',
                'subject.max' => 'Judul pesan maksimal 50 karakter',
                'subject.min' => 'Judul pesan minimal 3 karakter',
                'messages.required' => 'Masukkan isi pesan kamu',
                'messages.max' => 'Isi pesan maksimal 300 karakter',
                'messages.min' => 'Isi pesan minimal 5 karakter',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'errors' => $validator->errors()->toArray()
                ]
            );
        } else {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->messages,
            ];

            $setting = WebSetting::find(1);


            $query = Contact::create($data);

            if ($query) {
                return response()->json(
                    [
                        'status' => 200,
                        'msg' => 'Terimakasih atas pesan-mu'
                    ]
                );
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            Alert::success('Success', 'Kontak dengan subjek ' . $contact->subject . ' berhasil dihapus');
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Terjadi kesalahan saat menghapus kontak.
                Pesan: ' . $th->getMessage()
            );
        }

        return redirect()->back();
    }

    public function showInbox($id)
    {
        $data = Contact::find($id);

        if ($data) {
            return response()->json([
                'status' => 200,
                'dataInbox' => $data
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'msg' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function replay(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'judul' => 'required|string|max:50|min:3',
                'replay' => 'required|min:5',
            ],
            [
                'replay.required' => 'Masukkan isi pesan kamu',
                'replay.min' => 'Isi pesan minimal 5 karakter',
                'judul.required' => 'Masukkan judul pesan kamu',
                'judul.string' => 'Judul pesan tidak boleh mengandung angka dan lain-lain',
                'judul.max' => 'Judul pesan maksimal 50 karakter',
                'judul.min' => 'Judul pesan minimal 3 karakter',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 400,
                    'errors' => $validator->errors()->toArray()
                ]
            );
        } else {
            $data = Contact::find($id);

            $contact = [
                'name' => $data->name,
                'email' => $data->email,
                'subject' => $data->subject,
                'message' => $data->message,
                'judul' => $request->judul,
                'replay' => $request->replay
            ];

            $data->replay_subject = $request->judul;
            $data->replay_message = $request->replay;
            $data->status = "answered";
            $data->answerer = Auth::user()->name;

            $data->update();

            Mail::to($data->email)->send(new ReplayInbox($contact));

            return response()->json(
                [
                    'status' => 200,
                    'msg' => 'Email berhasil dikirim'
                ]
            );

            // return new ReplayInbox($contact);
        }
    }
}
