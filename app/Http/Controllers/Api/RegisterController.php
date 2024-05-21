<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {

        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        $token = $user->createToken('token')->plainTextToken;

        Mail::to($user)->send(new EmailVerification($user));

        $name = $user->name;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'name' => $name
        ], Response::HTTP_OK);
    }
}
