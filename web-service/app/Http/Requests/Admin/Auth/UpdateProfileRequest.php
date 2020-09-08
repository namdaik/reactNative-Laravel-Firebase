<?php

namespace App\Http\Requests\Admin\Auth;

use App\Rules\Admin\Auth\checkPasswordRule;
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
        $id = Auth::guard('api-employee')->user()->id;
        $validate = [
            'name' => 'required|min:6|max:50',
            'phone' => [
                'required',
                'regex :/(09[6-8]|086|03[2-9]|08[3-5]|08[1-2]|088|091|094|07[6-8]|089|090|093|070|079)\d{7}$\b/',
                'unique:employees,phone,' . $id,
            ],
            'email' => 'required|email|unique:employees,email,' . $id,
            'gender' => 'required|boolean',
            'address' => 'required',
            'password' => 'sometimes|confirmed|min:6',
            'avatar' => 'sometimes'
        ];
        if ($this->password) {
            $validate['current_password'] = ['required', new checkPasswordRule()];
        }
        return $validate;
    }
}
