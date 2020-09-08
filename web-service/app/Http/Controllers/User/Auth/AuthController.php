<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private function user()
    {
        return Auth::guard('api')->user();
    }

    public function getInfo()
    {
        $user = new UserResource($this->user());
        return $this->json(compact('user'));
    }

    public function onNotification(Request $request)
    {
        $this->user()->saveMobileToken($request->mobile_token);
        return $this->json(['success']);
    }

    public function offNotification(Request $request)
    {
        $this->user()->removeMobileToken($request->mobile_token);
        return $this->json(['success']);
    }
}
