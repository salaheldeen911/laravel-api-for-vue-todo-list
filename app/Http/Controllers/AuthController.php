<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $token = $user->createToken("token")->plainTextToken;

        return response()->json(["user" => new UserResource($user), "token" => $token]);
    }

    public function logout(User $user)
    {
        $user->tokens()->delete();

        return response()->json(["status" => "loged out"]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return abort(400, "bad email or password");
        }

        $token = $user->createToken("token")->plainTextToken;

        return response()->json(["user" => new UserResource($user), "token" => $token]);
    }

    public function check()
    {
        // return response()->json(["status" => auth('sanctum')->check()]);
    }
}
