<?php

namespace App\Http\Controllers;

use App\Models\EmailMessage;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
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
}
