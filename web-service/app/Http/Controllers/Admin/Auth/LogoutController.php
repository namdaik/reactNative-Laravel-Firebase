<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        return $this->json($this->guard()->logout());
    }

    /**
     * @return mixed
     */
    private function guard()
    {
        return Auth::guard('api-employee');
    }
}
