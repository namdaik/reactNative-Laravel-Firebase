<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updateProfileUser(UpdateProfileRequest $request)
    {
        $user = User::findOrFail($this->guard()->user()->id);
        $req = $request->only('name', 'address', 'email', 'password', 'avatar', 'gender');
        if (!empty($req['password'])) {
            $req['password'] = bcrypt($request->password);
        }
        $user->update($req);
        return $this->json(compact('user'));
    }

    private function guard()
    {
        return Auth::guard('api');
    }
}
