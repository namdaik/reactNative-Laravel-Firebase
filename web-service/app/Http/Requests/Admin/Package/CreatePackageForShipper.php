<?php

namespace App\Http\Requests\Admin\Package;

use App\Rules\Admin\Package\CheckOrderForShipper;
use App\Rules\Admin\Package\CheckShipper;
use App\Rules\Admin\Package\CheckStationOrder;
use Illuminate\Foundation\Http\FormRequest;

class CreatePackageForShipper extends FormRequest
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
            'order_ids' => [
                'required', 'exists:orders,id',
                new CheckStationOrder(), new CheckOrderForShipper()
            ],
            'next_employee_id' => [
                'required',
                'exists:employees,id',
                new CheckShipper()
            ]
        ];
    }
}
