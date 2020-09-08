<?php

namespace App\Http\Requests\User\Auth;

use App\Rules\User\Auth\checkPasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = Auth::guard('api')->user()->id;
        $validate = [
            'name' => 'required|min:6|max:50',
            'avatar' => 'sometimes',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'sometimes|confirmed|min:6'
        ];
        if ($this->password) {
            $validate['current_password'] = ['required', new checkPasswordRule()];
        }
        return $validate;
    }
}
