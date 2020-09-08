<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Http\Requests\User\Auth\SendOtpRequest;
use App\Http\Requests\User\Auth\VerifyOtpRequest;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    ** Send request information(name,phone)
    **
    */
    protected function guard()
    {
        return Auth::guard('api');
    }
    public function register(RegisterRequest $request)
    {
        $user = $request->only(['name', 'phone', 'email', 'gender', 'password', 'address', 'avatar']);
        if (Session::get($user['phone']) == $request->otp) {
            Session::forget($user['phone']);
            $user['password'] = bcrypt($request->password);
            return $this->json(User::create($user));
        }
        return $this->json(['otp' => trans('passwords.otp.invalid')]);
    }

    public function sendOtp(SendOtpRequest $request)
    {
        $phone = $request->phone;
        if (!$this->otpCheck($phone, 'throttle')) {
            $min = ['min' => config('auth.otp.throttle')];
            return $this->json(["phone" => trans('passwords.otp.throttled',$min)]);
        }
        $otp = rand(100000, 999999);
        $url = 'http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get';
        $config = http_build_query(
            [
                'Phone' => 'Ma OTP cua ban la' . $phone,
                'Content' => $otp,
                'ApiKey' => env('OTP_KEY', '85DB6727B810F285A0B286E5840F5B'),
                'SecretKey' => env('OTP_SECRET', '030B13A97557D19F1B6EF3E7AE8588'),
                'Brandname' => 'Verify',
                'SmsType' => 2,
                'Sandbox' => 0
            ]
        );
        $curl = curl_init("$url?$config");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $obj = json_decode($result, true);
        if ($obj['CodeResult'] == 100) {
            Session::put([
                "$phone" => $otp,
                "$phone-exp" => microtime(true)
            ]);
            return $this->json(trans('passwords.otp.sent'));
        } else {
            $not_regex = ['phone' => [trans('validation.not_regex',['attribute' => trans('validation.attributes.phone')])]];
            return $this->json($not_regex, 400);
        }
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $phone = $request->phone;
        $otp = $request->otp;
        if (Session::get("$phone") == $otp && !$this->otpCheck($phone, 'expire')) {
            return $this->json(compact('phone', 'otp'));
        }
        return $this->json(['otp' => trans('passwords.otp.invalid')], 400);
    }

    public function otpCheck($phone, $type = 'throttle')
    {
        $created_at = Session::get("$phone-exp", 0);
        $life = microtime(true) - (60 * config("auth.otp.$type", 5));
        return  $created_at < $life;
    }
}
