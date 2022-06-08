<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\UserPostApproved;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // public function notify()
    // {
    //     if (auth()->user()) {
    //         $user = User::first();
    //         auth()->user()->notify(new UserPostApproved($user));
    //     }

    //     dd('Notification sent');
    // }

    public function markAsRead($id)
    {
        if ($id) {
            auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        }
        return back();
    }
}
