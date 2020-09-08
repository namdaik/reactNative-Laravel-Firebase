<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\UpdateProfileRequest;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateProfileEmployee(UpdateProfileRequest $request)
    {
        $employee = Employee::findOrFail($this->guard()->user()->id);
        $req = $request->only('name', 'phone', 'address', 'email', 'password', 'avatar', 'gender');
        if (!empty($req['password'])) {
            $req['password'] = bcrypt($request->password);
        }
        $employee->update($req);
        return $this->json(compact('employee'));
    }

    private function guard()
    {
        return Auth::guard('api-employee');
    }
}
