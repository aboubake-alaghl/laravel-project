<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validatedBody = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'email' => 'required|string|email|max:255|unique:users,email',
        ]);
        $created_admin = User::create($validatedBody);
        $token = $created_admin->createToken(time())->plainTextToken;
        return response([
            'admin' => $created_admin,
            'token' => $token
        ], 201);
    }

    public function signin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ]);

        $admin = User::where('email', $data['email'])->first();

        if (!$admin) {
            return response(['invalid credentials'], 401);
        }

        if (Hash::check($data['password'], $admin->getAuthPassword())) {
            // Todo: if this line is kept, this means that the user CAN BE ONLY AUTHENTICATED IN ONE DEVICE ONLY.
            $admin->tokens()->delete(); // only be signed in, in this browser
            return [
                'admin' => $admin,
                'token' => $admin->createToken(time())->plainTextToken
            ];
        } else {
            return response(['invalid credentials'], 401);
        }
    }
}
