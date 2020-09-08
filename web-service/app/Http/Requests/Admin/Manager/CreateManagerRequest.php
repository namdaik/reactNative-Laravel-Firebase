<?php

namespace App\Http\Requests\Admin\Manager;

use App\Rules\Admin\Manager\CheckManagerInTransactionPointRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateManagerRequest extends FormRequest
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
        return [
            'name' => 'required|min:6|max:50',
            'email' => 'required|email|unique:employees,email',
            'phone' => [
                'required',
                'regex :/(09[6-8]|086|03[2-9]|08[3-5]|08[1-2]|088|091|094|07[6-8]|089|090|093|070|079)\d{7}$\b/',
                'unique:employees,phone'
            ],
            'gender' => 'required',
            'address' => 'required',
            'password' => 'required|confirmed|min:6',
            'avatar' => 'required',
            'transaction_point_id' => ['required', 'exists:transaction_points,id', new CheckManagerInTransactionPointRule()],
        ];
    }
}
