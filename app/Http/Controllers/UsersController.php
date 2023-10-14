<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAutenticationRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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
        $token = $user->createToken($user->username, ['user'])->plainTextToken;
        return response()->json(['status' => true, 'resp' => $user, 'token' => $token]);
    }

    public function Login(UserAutenticationRequest $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Correo o contraseña invalido']);
        }

        $user->tokens()->delete();
        $token = $user->createToken($user->username, ['user'])->plainTextToken;
        return response()->json(['status' => true, 'resp' => $user, 'token' => $token]);
    }
}
