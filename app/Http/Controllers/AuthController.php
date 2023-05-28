<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => bcrypt($req->password),
        ]);
        $regDetail['token'] = $user->createToken('authToken')->plainTextToken;
        $regDetail['name'] = $user->name;
        return $this->sendResponse($regDetail, "User registered successfully");
    }
    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }
        if(auth()->attempt([
            'email' => $req->email,
            'password' => $req->password,
        ])) {
            $user  = User::where('email', $req->email)->first();
            $user->tokens->each(function($token, $key) {
                $token->delete();
            });
            $loginDetail['token'] = $user->createToken('authToken')->plainTextToken;
            $loginDetail['name'] = $user->name;
            return $this->sendResponse($loginDetail, "User logged in successfully");
        } else {
            return $this->sendError("unverified", ['error' => "provided credentials couldn't be verified"], 401);
        }
    }
}
