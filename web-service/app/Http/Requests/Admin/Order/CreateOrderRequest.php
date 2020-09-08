<?php

namespace App\Http\Requests\Admin\Order;

use App\Rules\Admin\Order\CheckPlaceOfShipmentRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
        $validation = [
            'receivers' => 'required|array',
            'receivers.name' => 'required|string|max:255',
            'receivers.address' => 'required|string',
            'receivers.ward' => 'required|exists:wards,id',
            'receivers.phone' => [
                'required',
                'regex :/(09[6-8]|086|03[2-9]|08[3-5]|08[1-2]|088|091|094|07[6-8]|089|090|093|070|079)\d{7}$\b/'
            ],
            'parcel_weight' => 'required|numeric|max:20000',
            'parcel_height' => 'required|numeric|max:80',
            'parcel_length' => 'required|numeric|max:80',
            'parcel_width' => 'required|numeric|max:80',
            'is_paid' => 'required',
            'user_id' => 'sometimes|exists:users,id|',
            'place_of_shipment_id' => [
                'sometimes', 'exists:place_of_shipments,id',
                new CheckPlaceOfShipmentRule($this->user_id)
            ]
        ];
        if (empty($this->user_id)) {
            $validation = array_merge($validation, [
                'user.name' => 'required|string|max:255',
                'user.phone' => [
                    'required',
                    'regex :/(09[6-8]|086|03[2-9]|08[3-5]|08[1-2]|088|091|094|07[6-8]|089|090|093|070|079)\d{7}$\b/',
                    'unique:users,phone'
                ],
                'user.email' => 'required|email|unique:users,email',
            ]);
        }
        if (empty($this->place_of_shipment_id)) {
            $validation = array_merge($validation, [
                'place_of_shipment.name' => 'required|string|max:255',
                'place_of_shipment.phone' => [
                    'required',
                    'regex :/(09[6-8]|086|03[2-9]|08[3-5]|08[1-2]|088|091|094|07[6-8]|089|090|093|070|079)\d{7}$\b/',
                ],
                'place_of_shipment.address' => 'required|string|max:255',
                'place_of_shipment.province_id' => 'required|exists:provinces,id',
                'place_of_shipment.district_id' => 'required|exists:districts,id',
                'place_of_shipment.ward_id' => 'required|exists:wards,id'
            ]);
        }
        return $validation;
    }
}
