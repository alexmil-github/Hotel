<?php

namespace App\Http\Controllers;

use App\Http\Requests\DismissUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where([
            ['login', '=', $request->login],
            ['password', '=', $request->password],
        ])->first();

        if ($user) {
            $user->api_token = Str::random(32);
            $user->save();
            return [
                'data' => [
                    'user_token' => $user->api_token
                ]
            ];
        }
//        return response()->json([
//            'error' => [
//                'code' => 401,
//                'message' => 'Authentication failed'
//            ]
//        ])->setStatusCode(401);
    }

    public function logout()
    {
        if (Auth::user()) {
            Auth::user()->logout();
            return [
                'data' => [
                    'message' => 'logout'
                ]
            ];
        }

    }

    public function index()
    {
        if (Auth::user()->is_admin == 0) {
            return response()->json([
                'error' => [
                    'code' => '403',
                    'message' => 'Forbidden for you'
                ]
            ]);
        }
        return response()->json(['data' => User::where('is_admin', 0)->get()]);
    }

    public function store(RegisterUserRequest $userRequest)
    {
        if (Auth::user()->is_admin == 0) {
            return response()->json([
                'error' => [
                    'code' => '403',
                    'message' => 'Forbidden for you'
                ]
            ]);
        }

        $user = User::create([
                'password' => $userRequest->password,
                'photo_file' => $userRequest->photo_file ? $userRequest->photo_file->store('public') : null,
            ] + $userRequest->all()
        );

        return response()->json([
            'data' => [
                'id' => $user->id,
                'status' => 'created'
            ]
        ])->setStatusCode(201, 'Created');
    }

    public function toDismiss(User $user, DismissUserRequest $dismissUserRequest)
    {
        if (Auth::user()->is_admin == 0) {
            return response()->json([
                'error' => [
                    'code' => '403',
                    'message' => 'Forbidden for you'
                ]
            ]);
        }

        return [
            'data' => [
                'id' => $user->toDismiss()->id,
                'status' => 'fired'
            ]
        ];
    }

}
