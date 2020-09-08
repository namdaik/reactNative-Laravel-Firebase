<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;

class AuthController extends Controller
{
    private function guard()
    {
        return Auth::guard('api-employee');
    }

    public function employee()
    {
        return $this->json(new EmployeeResource($this->guard()->user()));
    }
}
