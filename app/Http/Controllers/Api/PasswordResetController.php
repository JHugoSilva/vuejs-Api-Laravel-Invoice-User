<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Mail\ResetPasswordLink;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;


class PasswordResetController extends Controller
{

    public function sendResetLink(LinkEmailRequest $request) {

        $url = URL::temporarySignedRoute('password.reset', now()->addMinute(10), ['email' => $request->email]);

        $url = str_replace(env('APP_URL'), env('FRONT_END'), $url);


        Mail::to($request->email)->send(new ResetPasswordLink($url));

        return response()->json([
            'message' => 'Reset password link sent on your email.'
        ], Response::HTTP_OK);
    }

    public function reset(ResetPasswordRequest $request) {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User Not Fount'
            ], Response::HTTP_NOT_FOUND);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password reset succesfully'
        ], Response::HTTP_OK);
    }

}
