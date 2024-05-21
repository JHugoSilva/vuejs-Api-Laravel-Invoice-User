<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;


class VerifyEmailController extends Controller
{

    public function sendMail() {

        Mail::to(auth()->user())->send(new EmailVerification(auth()->user()));

        return response()->json([
            'message' => 'Email verification link send on your email.'
        ],Response::HTTP_OK);
    }

    public function verify(Request $request) {

        if (!$request->user()->email_verified_at) {
            $request->user()->forceFill([
                'email_verified_at' => now()
            ])->save();
            return response()->json([
                'message' => 'Email verified'
            ], Response::HTTP_OK);
        }

    }

}
