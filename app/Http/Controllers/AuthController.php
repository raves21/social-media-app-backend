<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $req)
    {
        User::create($req->validated());

        return ["message" => "account successfully created"];
    }

    public function login(AuthLoginRequest $req)
    {

        if (Auth::attempt($req->validated(), true)) {
            $req->session()->regenerate();
            return ["message" => "logged in successfully."];
        }

        return ["error" => "wrong email or password."];
    }

    public function logout(Request $req)
    {
        Auth::guard('web')->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return ["message" => "successfully logged out."];
    }
}
