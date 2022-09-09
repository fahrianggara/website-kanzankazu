<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Lib\PusherFactory;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Pusher\Pusher;

class MessageController extends Controller
{
    public function index()
    {
        $auth_id = Auth::id();
        $users = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.user_image',
                'users.last_seen',
                'users.uid',
                'users.email',
                DB::raw('count(is_read) as unread')
            )
            ->leftJoin('messages', function ($join) use ($auth_id) {
                $join->on('users.id', '=', 'messages.user_id')->where('messages.is_read', 0)
                    ->where('receiver_id', $auth_id);
            })->where('users.id', '!=', $auth_id)
            ->groupBy(
                'users.id',
                'users.name',
                'users.user_image',
                'users.last_seen',
                'users.uid'
            )
            ->orderBy('users.last_seen', 'DESC')
            ->get();

        return view('dashboard.contact.chat.index', [
            'users' => $users,
        ]);
    }

    public function fetchUsers()
    {
        $output = '';
        $my_id = Auth::id();

        $users = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.user_image',
                'users.last_seen',
                'users.uid',
                'users.email',
                DB::raw('count(is_read) as unread')
            )
            ->leftJoin('messages', function ($join) use ($my_id) {
                $join->on('users.id', '=', 'messages.user_id')->where('messages.is_read', 0)
                    ->where('receiver_id', $my_id);
            })->where('users.id', '!=', $my_id)
            ->groupBy(
                'users.id',
                'users.name',
                'users.user_image',
                'users.last_seen',
                'users.uid'
            )
            ->orderBy('users.last_seen', 'DESC')
            ->get();


        if ($users->count() > 0) {
            foreach ($users as $user) {
                if (file_exists("vendor/dashboard/image/picture-profiles/" . $user->user_image)) {
                    $userImage = asset("vendor/dashboard/image/picture-profiles/" . $user->user_image);
                } else if ($user->uid != null) {
                    $userImage = $user->user_image;
                } else {
                    $userImage = asset("vendor/dashboard/image/avatar.png");
                }

                if (Cache::has('user-is-online-' . $user->id)) {
                    $statusText = '<div class="status text-success">Online</div>';
                } else {
                    $statusText = '<div class="status text-secondary">' . Carbon::parse($user->last_seen)->diffForHumans() . '</div>';
                }

                if (strlen($user->name) > 10) {
                    $name = substr($user->name, 0, 11) . '..';
                } else {
                    $name = $user->name;
                }

                if ($user->unread) {
                    $read = '<span class="badge badge-danger badge-pill">' . $user->unread . '</span>';
                } else {
                    $read = '';
                }

                if ($user->email == null) {
                    $email = 'Anonymous';
                } else {
                    $email = $user->email;
                }

                $output .= '

                    <li id="' . $user->id . '" class="clearfix chat-toggle" style="cursor: pointer;">
                        <img class="user-image rounded-circle" src="' . $userImage . '" alt="">
                        <div class="about">
                            <div class="name" >
                                ' . $name . '
                                ' . $read . '
                            </div>
                            ' .  $statusText . '
                        </div>
                    </li>

                ';
            }
        } else {
            $output .= '<a href="javascript:void(0)" class="text-center"><li class="clearfix">hmm, sepertinya belum ada yang menge-chat.</li></a>';
        }

        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        $data = [
            'users' => $users,
        ];
        $pusher->trigger('users', 'fetch', $data);

        echo $output;
    }

    public function searchUsersChat(Request $request)
    {
        $output = '';
        $my_id = Auth::id();

        $users = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.user_image',
                'users.last_seen',
                'users.uid',
                'users.email',
                DB::raw('count(is_read) as unread')
            )
            ->leftJoin('messages', function ($join) use ($my_id) {
                $join->on('users.id', '=', 'messages.user_id')->where('messages.is_read', 0)
                    ->where('receiver_id', $my_id);
            })->where('users.id', '!=', $my_id)
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->groupBy(
                'users.id',
                'users.name',
                'users.user_image',
                'users.last_seen',
                'users.uid'
            )
            ->orderBy('users.last_seen', 'DESC')
            ->get();

        if ($users->count() > 0) {
            foreach ($users as $user) {
                // Image
                if (file_exists("vendor/dashboard/image/picture-profiles/" . $user->user_image)) {
                    $userImage = asset("vendor/dashboard/image/picture-profiles/" . $user->user_image);
                } else if ($user->uid != null) {
                    $userImage = $user->user_image;
                } else {
                    $userImage = asset("vendor/dashboard/image/avatar.png");
                }

                if (Cache::has('user-is-online-' . $user->id)) {
                    $statusText = '<div class="status text-success">Online</div>';
                } else {
                    $statusText = '<div class="status text-secondary">' . Carbon::parse($user->last_seen)->diffForHumans() . '</div>';
                }

                if (strlen($user->name) > 10) {
                    $name = substr($user->name, 0, 11) . '..';
                } else {
                    $name = $user->name;
                }

                if ($user->unread) {
                    $read = '<span class="badge badge-danger badge-pill">' . $user->unread . '</span>';
                } else {
                    $read = '';
                }

                if ($user->email == null) {
                    $email = 'Anonymous';
                } else {
                    $email = $user->email;
                }

                $output .= '

                    <li id="' . $user->id . '" class="clearfix chat-toggle" style="cursor: pointer;">
                        <img class="user-image rounded-circle" src="' . $userImage . '" alt="">
                        <div class="about">
                            <div class="name" >
                                ' . $name . '
                                ' . $read . '
                            </div>
                            ' .  $statusText . '
                        </div>
                    </li>

                ';
            }
        } else {
            $output .= '<a href="javascript:void(0)" class="text-center"><li class="clearfix">Pengguna tidak ditemukan</li></a>';
        }

        return response($output);
    }

    public function getMessageAdmin($user_id)
    {
        $my_id = Auth::id();
        $user = User::find($user_id);

        Message::where([
            'user_id' => $user_id,
            'receiver_id' => $my_id,
        ])->update(['is_read' => 1]);

        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('user_id', $my_id)->where('receiver_id', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('user_id', $user_id)->where('receiver_id', $my_id);
        })->get();

        return view('dashboard.contact.chat.layouts.chat-box', [
            'messages' => $messages,
            'user' => $user
        ]);
    }

    public function sendToClient(Request $request)
    {
        $user_id = Auth::id();
        $receiver_id = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->user_id = $user_id;
        $data->receiver_id = $receiver_id;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = [
            'receiver_id' => $receiver_id,
            'user_id' => $user_id,
        ];
        $pusher->trigger('my-channel', 'my-event', $data);
    }

    public function listAdmin()
    {
        // ada di appservice provider
    }

    public function getMessageClient($user_id)
    {
        $my_id = Auth::id();
        $user = User::find($user_id);

        Message::where([
            'user_id' => $user_id,
            'receiver_id' => $my_id,
        ])->update(['is_read' => 1]);

        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('user_id', $my_id)->where('receiver_id', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('user_id', $user_id)->where('receiver_id', $my_id);
        })->get();

        return view('layouts._layouts.chat.chat-box', [
            'messages' => $messages,
            'user' => $user
        ]);
    }

    public function sendToAdmin(Request $request)
    {
        $user_id = Auth::id();
        $receiver_id = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->user_id = $user_id;
        $data->receiver_id = $receiver_id;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = [
            'receiver_id' => $receiver_id,
            'user_id' => $user_id,
        ];
        $pusher->trigger('my-channel', 'my-event', $data);
    }
}
