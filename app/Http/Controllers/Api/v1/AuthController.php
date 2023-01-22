<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login (LoginRequest $request) {
        Auth::attempt($request->only(['email', 'password']));

        $access_token = auth()->user()->createToken(
            'logged-in-token',
            ['quizzes-edit'],
        );

        return ['access_token' => $access_token->plainTextToken];
    }
}
