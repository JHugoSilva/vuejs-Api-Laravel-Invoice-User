<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {

            return response()->json([
                'msg' => 'Usuário não autorizado'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();

        $token = $user->createToken('token')->plainTextToken;
        $name = $user->name;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'name' => $name
        ], Response::HTTP_OK);
    }
}
