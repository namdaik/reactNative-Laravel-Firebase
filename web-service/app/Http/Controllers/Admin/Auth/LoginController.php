<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Resources\EmployeeResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private function guard()
    {
        return Auth::guard('api-employee');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            $employee_logged_in = $this->guard()->getLastAttempted();
            if ($employee_logged_in->is_active) {
                $employee = new EmployeeResource($this->guard()->user());
                return $this->json(compact('employee', 'token'))->header('Authorization', $token);
            } else {
                throw new AuthenticationException();
            }
        }
        throw new AuthenticationException();
    }
}
