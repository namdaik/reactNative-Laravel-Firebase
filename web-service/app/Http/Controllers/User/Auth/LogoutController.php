<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        $this->guard()->user()->removeMobileToken(request()->mobile_token);
        return $this->json($this->guard()->logout());
    }
    /**
     * @return mixed
     */
    private function guard()
    {
        return Auth::guard('api');
    }
}
