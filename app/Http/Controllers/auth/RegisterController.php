<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        try{
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $token = Auth::login($user);
            return response()->json([
                'token'=>$token,
                'user'=>$user,
                'message'=>'Registration has beedn completed successfully'
            ],200);
        }catch(Exception){
        return response()->json([
            'message'=>'Something went wrong with registration'
        ],401);
        }
    }
}
