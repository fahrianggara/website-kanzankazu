<?php

namespace App\Http\Controllers;

use App\Mail\MailMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail($title, $subject, $body, $email, $name = '', $admin = '')
    {
        $credentials = [
            'title' => $title,
            'subject' => $subject,
            'body' => $body,
            'email' => $email
        ];

        Mail::to($email)->send(new MailMaster($credentials));
    }
}
