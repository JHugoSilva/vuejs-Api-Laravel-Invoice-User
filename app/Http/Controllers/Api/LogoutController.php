<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'mgs' => 'Logout',
        ], Response::HTTP_NO_CONTENT);

    }
}
