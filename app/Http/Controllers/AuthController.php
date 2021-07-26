<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;

                return response([
                    'message' => "Successfully Login",
                    'token' => $token,
                    'user' => $user
                ], 200);
            }
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'Invalid Email or Password'
        ], 401);
    } // end method

    public function register(RegisterRequest $registerRequest){
        try {
            $user = User::create([
                'name' => $registerRequest->name,
                'email' => $registerRequest->email,
                'password' => Hash::make($registerRequest->password)
            ]);
            $token = $user->createToken('app')->accessToken;
            return response([
                'message' => 'Registration Successfully',
                'token' => $token,
                'user' => $user
            ], 200);

        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    } // end method
}
