<?php

namespace App\Http\Requests\User\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'parcel_weight' => 'required|numeric|min:1|max:20000',
            'parcel_height' => 'required|numeric|min:1|max:80',
            'parcel_length' => 'required|numeric|min:1|max:80',
            'parcel_width' => 'required|numeric|min:1|max:80',
            'price' => 'required',
            'is_paid' => 'required',
        ];
    }
}
