<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    private function guard()
    {
        return Auth::guard('api');
    }

    public function login(LoginRequest $request)
    {
        $field = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $credentials = [
            $field     => $request->username,
            'password' => $request->password
        ];
        if ($token = $this->guard()->attempt($credentials)) {
            $user_logged_in = $this->guard()->getLastAttempted();
            if ($user_logged_in->is_active) {
                $user = $this->guard()->user();
                $user->saveMobileToken($request->mobile_token);
                return $this->json(compact('token', 'user'));
            } else {
                throw new AuthenticationException();
            }
        }
        throw new AuthenticationException();
    }
}
