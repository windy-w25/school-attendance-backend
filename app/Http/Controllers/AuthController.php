<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller {
    public function login(Request $req) {
        $credentials = $req->validate([
            'email'=>'required|email','password'=>'required'
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message'=>'Invalid credentials'], 401);
        }
        $user = $req->user();
 
        $token = $user->createToken('web', [$user->role])->plainTextToken;
        return response()->json(['token'=>$token,'user'=>$user]);
    }

    public function logout(Request $req) {
        $req->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }
}

