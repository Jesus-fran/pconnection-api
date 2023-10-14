<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function Index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function Store()
    {
        $user = new User();
        $user->email = 'fran@gmail.com';
        $user->password = '123';
        $user->username = 'fran';
        $user->created_at = Carbon::now();

        if (!$user->save()) {
            return response()->json(['status' => false]);
        }
        $token = $user->createToken('cadena', ['user'])->plainTextToken;
        return response()->json(['status' => true, 'resp' => $user, 'token' => $token]);
    }
}
