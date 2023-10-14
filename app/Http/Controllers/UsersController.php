<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function Index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function Store(UserRegistrationRequest $request)
    {
        $user = new User();
        $user->email = $request->email;
        $user->password = $request->password;
        $user->username = $request->username;
        $user->created_at = Carbon::now();

        if (!$user->save()) {
            return response()->json(['status' => false]);
        }
        $token = $user->createToken('cadena', ['user'])->plainTextToken;
        return response()->json(['status' => true, 'resp' => $user, 'token' => $token]);
    }
}
