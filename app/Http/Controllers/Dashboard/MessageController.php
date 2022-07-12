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
use Illuminate\Support\Facades\Response;

class MessageController extends Controller
{
    public function index()
    {
        return view('dashboard.chat.index');
    }

    public function fetchUsers()
    {
        $output = '';
        $users = User::where('id', '!=', Auth::id())->where('provider', '!=', 'anonymous')->get();

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
                    $statusIcon = '<div class="status-circle online"></div>';
                    $statusText = '<div class="status text-success">Online</div>';
                } else {
                    $statusIcon = '<div class="status-circle offline"></div>';
                    $statusText = '<div class="status text-secondary">Offline</div>';
                }

                if (strlen($user->name) > 10) {
                    $name = substr($user->name, 0, 11) . '..';
                } else {
                    $name = $user->name;
                }

                $output .= '
                    <li id="selectChatUser" class="clearfix">
                        <a href="javascript:void(0)" class="chat-toggle" data-id="' . $user->id . '" data-name="' . $user->name . '" data-lastseen="Terakhir dilihat ' . Carbon::parse($user->last_seen)->diffForHumans() . '" data-avatar="' . $userImage . '">
                            <img class="rounded-circle user-image" src="' . $userImage . '" alt="">
                            ' . $statusIcon . '
                            <div class="about">
                                <div class="name">
                                    ' . $name . '
                                </div>
                                ' . $statusText . '
                            </div>
                        </a>
                    </li>
                    ';
            }
        } else {
            $output .= '<a href="javascript:void(0)" class="text-center"><li class="clearfix">Pengguna tidak ditemukan</li></a>';
        }

        echo $output;
    }

    public function searchUsersChat(Request $request)
    {
        $output = '';
        $users = User::where('id', '!=', Auth::id())->where('provider', '!=', 'anonymous')->where('name', 'LIKE', '%' . $request->search . '%')->get();

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
                    $statusIcon = '<div class="status-circle online"></div>';
                    $statusText = '<div class="status text-success">Online</div>';
                } else {
                    $statusIcon = '<div class="status-circle offline"></div>';
                    $statusText = '<div class="status text-secondary">Offline</div>';
                }

                if (strlen($user->name) > 10) {
                    $name = substr($user->name, 0, 11) . '..';
                } else {
                    $name = $user->name;
                }

                $output .= '
                    <li id="selectChatUser" class="clearfix">
                        <a href="javascript:void(0)" class="chat-toggle" data-id="' . $user->id . '" data-name="' . $user->name . '" data-lastseen="Terakhir dilihat ' . Carbon::parse($user->last_seen)->diffForHumans() . '" data-avatar="' . $userImage . '">
                            <img class="rounded-circle user-image" src="' . $userImage . '" alt="">
                            ' . $statusIcon . '
                            <div class="about">
                                <div class="name">
                                    ' . $name . '
                                </div>
                                ' . $statusText . '
                            </div>
                        </a>
                    </li>
                    ';
            }
        } else {
            $output .= '<a href="javascript:void(0)" class="text-center"><li class="clearfix">Pengguna tidak ditemukan</li></a>';
        }

        return response($output);
    }

    public function getLoadLatestMessage(Request $request)
    {
        if (!$request->user_id) {
            return;
        }

        $messages = Message::where(function ($q) use ($request) {
            $q->where('from_user', '=', Auth::user()->id)->where('to_user', '=', $request->user_id);
        })->orWhere(function ($q) use ($request) {
            $q->where('from_user', '=', $request->user_id)->where('to_user', '=', Auth::user()->id);
        })->orderBy('created_at', 'ASC')->get();

        $return = [];

        foreach ($messages as $message) {
            $return[] = view('dashboard.chat.layouts.message-line')->with('message', $message)->render();
        }
        return response()->json([
            'messages' => $return,
            'state' => 1
        ]);
    }

    public function postSendMessage(Request $request, Message $message)
    {
        if (!$request->to_user || !$request->message) {
            return;
        }

        $message->from_user = Auth::user()->id;
        $message->to_user = $request->to_user;
        $message->content = $request->message;
        $message->save();

        $message->dateTimeStr = date("H.i T", strtotime($message->created_at->toDateTimeString()));
        $message->userImage = $message->fromUser->user_image;
        $message->userUid = $message->fromUser->uid;
        $message->from_user_id = Auth::id();
        $message->to_user_id = $request->to_user;
        PusherFactory::make()->trigger('chat', 'send', ['data' => $message]);
        return response()->json([
            'data' => $message,
            'state' => 1,
            'status' => 200
        ]);
    }

    public function getOldMessages(Request $request)
    {
        if (!$request->old_message_id || !$request->to_user) {
            return;
        }

        $message = Message::find($request->old_message_id);
        $lastMessage = Message::where(function ($q) use ($request, $message) {
            $q->where('from_user', '=', Auth::user()->id)
                ->where('to_user', '=', $request->to_user)
                ->where('id', '<', $message->id);
        })->orWhere(function ($q) use ($request, $message) {
            $q->where('from_user', '=', $request->to_user)
                ->where('to_user', '=', Auth::user()->id)
                ->where('id', '<', $message->id);
        })->orderBy('created_at', 'ASC')->get();

        $return = [];

        if ($lastMessage->count() > 0) {
            foreach ($lastMessage as $message) {
                $return[] = view('dashboard.chat.layouts.message-line')->with('message', $message)->render();
            }

            PusherFactory::make()->trigger('chat', 'oldMsgs', [
                'to_user' => $request->to_user,
                'data' => $return,
            ]);
        }

        return response()->json([
            'data' => $return,
            'state' => 1,
            'status' => 200
        ]);
    }
}
