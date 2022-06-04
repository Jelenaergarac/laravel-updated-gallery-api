<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class LoginController extends Controller
{
    public function login(Request $request){
    $data = $request->only(['email', 'password']);
    $token = Auth::attempt($data);

    if(!$token){
        return response()->json([
            'message'=>'Invalid credentials'
        ],401);
    }
    return response()->json([
        'token'=>$token,
        'user'=>Auth::user(),
        'message'=>'You are logged in successfully'
    ],200);
    }

    public function refreshToken(){
        
        try{
            $token = Auth::refresh();
            return [
                'token'=>$token
            ];

        }catch(TokenBlacklistedException $exception){
            return response()->json([
                'message'=>'Invalid token'
            ],401);
        }
    }
}
