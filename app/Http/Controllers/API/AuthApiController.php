<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid Field',
                'errors' => $validator->errors()
            ], 422);
        }
        $credentials = $request->only('username', 'password');
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Email/Username or password inccorect'
            ], 401);
        }
        $user = Auth::guard('api')->user();
        return response()->json([
            'message' => 'Login success',
            'token' => $token,
            'user' => $user
        ], 200);
    }
    public function logout(){
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
        if ($removeToken) {
            return response()->json([
                'message' => 'Logout success'
            ], 200);
        }
    }
    
}
