<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:inbox_show', ['only' => 'index']);
        $this->middleware('permission:inbox_delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $q = $request->get('keyword');

        $contact = $request->get('keyword') ? Contact::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('subject', 'LIKE', '%' . $q . '%')->paginate(5) : Contact::paginate(5);

        return view('contact.index', [
            'contact' => $contact->appends(['keyword' => $request->keyword])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (request()->ajax()) {
            return view('home.form.form-contact');
        } else {
            return redirect()->back();
        }
    }

    function save(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|regex:/^[a-zA-Z\s]*$/|min:3|max:40',
                "email" => 'required|email',
                'subject' => 'required|string|alpha_num|max:100|min:3',
                'message' => 'required|alpha_num|max:300|min:5',
            ],
            [],
            $this->attributes()
        );

        if (!$validator->passes()) {
            return response()->json(
                [
                    'status' => 0,
                    'error' => $validator->errors()->toArray()
                ]
            );
        } else {
            $values = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            $query = Contact::create($values);

            if ($query) {
                return response()->json(
                    [
                        'status' => 1,
                        'msg' => trans('home.alert.create.message.success')
                    ]
                );
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->ajax()) {
            $validator = Validator::make([
                $request->all(),
                [
                    'name' => 'required|string|min:3',
                    "email" => 'required|email',
                    'subject' => 'required|string|max:100',
                    'message' => 'required|max:300',
                ],
                [],
                $this->attributes()
            ]);

            if (!$validator) {
                $msg = [
                    "error" => [
                        'name' => $validator->message()->get('name'),
                        'email' => $validator->message()->get('email'),
                        'subject' => $validator->message()->get('subject'),
                        'message' => $validator->message()->get('message'),
                    ]
                ];
            } else {
                $saveContact = Contact::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'message' => $request->message,
                ]);

                $msg = [
                    'sukses' => trans('home.alert.create.message.success')
                ];
            }

            echo json_encode($msg);
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
            Alert::success('Success', 'Inbox with title ' . $contact->subject . ', Deleted successfully');
        } catch (\Throwable $th) {
            Alert::error(
                'Error',
                'Failed during data input process. 
                Message: ' . $th->getMessage()
            );
        }

        return redirect()->back();
    }

    private function attributes()
    {
        return [
            'name' => trans('home.contact.form.name.attribute'),
            'email' => trans('home.contact.form.email.attribute'),
            'subject' => trans('home.contact.form.subject.attribute'),
            'message' => trans('home.contact.form.message.attribute'),
        ];
    }
}
