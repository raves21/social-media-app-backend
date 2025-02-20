<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    public function show(string $id)
    {
        return new UserResource(User::findOrFail($id));
    }

    public function me(Request $req)
    {
        return new UserResource($req->user());
    }
}
