<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgetPassController extends Controller
{
    public function forgetPassword(ForgetRequest $forgetRequest)
    {
        $email = $forgetRequest->email;
        if (User::where('email', $email)->doesntExist()) {
            return response([
                'message' => 'Email invalid'
            ], 401);
        }

        // generate random token
        $token = rand(10, 100000);

        try {
            DB::table('password_resets')->updateOrInsert(['email' => $email], [
                'email' => $email,
                'token' => $token
            ]);
            // Mail send to user
            Mail::to($email)->send(new ForgetMail($token));

            return response([
                'message' => 'Reset password mail sent!'
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    } // end method
}
