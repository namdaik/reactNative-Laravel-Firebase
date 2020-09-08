<?php

namespace App\Http\Requests\Admin\TransactionPoint;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionPointRequest extends FormRequest
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
        $validate =  [
            'name' => 'required|min:6|max:50',
            'address' => 'required|max:255',
            'ward_id' => 'required|exists:wards,id',
            'district_id' => 'required|exists:districts,id',
            'province_id' => 'required|exists:provinces,id',

        ];
        if ($this->manager) {
            $validate['manager.name'] = 'required|min:6|max:50';
            $validate['manager.email'] = 'required|email|unique:employees,email';
            $validate['manager.phone'] = [
                'required',
                'regex :/(09[6-8]|086|03[2-9]|08[3-5]|08[1-2]|088|091|094|07[6-8]|089|090|093|070|079)\d{7}$\b/',
                'unique:employees,phone'
            ];
            $validate['manager.gender'] = 'required';
            $validate['manager.address'] = 'required';
            $validate['manager.password'] = 'required|confirmed|min:6';
            $validate['manager.avatar'] = 'required';
        }
        return $validate;
    }
}
