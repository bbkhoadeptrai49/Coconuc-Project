<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\User;
use App\PasswordResets;
use App\Notifications\PasswordResetsRequest;

class ResetPasswordController extends Controller
{
    public function sendMail(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->firstOrFail();
        $passwordReset = PasswordResets::updateOrCreate(
        	[ 'email' => $user->email], [ 'token' => Str::random(60),
        ]);

        if ($passwordReset) {
            // $user->notify(new PasswordResets($passwordReset->token));
        }
  
        return response()->json([
        	'message' => 'We have e-mailed your password reset link!'
        ]);
    }

}
