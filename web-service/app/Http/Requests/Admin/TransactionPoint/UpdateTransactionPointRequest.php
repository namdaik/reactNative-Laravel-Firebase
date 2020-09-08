<?php

namespace App\Http\Requests\Admin\TransactionPoint;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionPointRequest extends FormRequest
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
            'address' => 'required|max:255',
            'ward_id' => 'sometimes|exists:wards,id',
            'district_id' => 'sometimes|exists:districts,id',
            'province_id' => 'sometimes|exists:provinces,id'
        ];
    }
}
