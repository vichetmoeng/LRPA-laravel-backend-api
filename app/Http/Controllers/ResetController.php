<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller
{
    public function resetPassword(ResetRequest $resetRequest)
    {
        $email = $resetRequest->email;
        $token = $resetRequest->token;
        $password = Hash::make($resetRequest->password);

        $emailCheck = DB::table('password_resets')->where('email', $email)->first();
        if (!$emailCheck) {
            return response([
                'message' => 'Email not found!'
            ], 401);
        }

        $emailCheck->token == $token ?  $pinCheck = true : $pinCheck = false;
        if (!$pinCheck) {
            return response([
                'message' => 'Pin Code Invalid'
            ], 401);
        }

        DB::table('users')->where('email', $email)->update(['password' => $password]);
        DB::table('password_resets')->where('email', $email)->delete();

        return response([
            'message' => 'Password change successfully'
        ], 200);

    } // end of method

}
