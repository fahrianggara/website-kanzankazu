<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\user;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::getUserByEmail($request->email);

        if (User::checkUserPassword($user, $request)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $token = User::createNewToken($user);

        return response()->json([
            'message' => 'Success',
            'data' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout Successfully'
        ]);
    }
}
