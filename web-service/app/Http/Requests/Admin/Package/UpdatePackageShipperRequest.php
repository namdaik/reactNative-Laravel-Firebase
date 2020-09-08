<?php

namespace App\Http\Requests\Admin\Package;

use App\Models\Package;
use App\Rules\Admin\Package\CheckOrderReturnRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageShipperRequest extends FormRequest
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
        $order_ids = json_decode(Package::where('id', $this->id)->firstOrFail()->order_ids);
        return [
            'order_returned_id' => [
                'sometimes', 'exists:orders,id',
                new CheckOrderReturnRule($order_ids)
            ]
        ];
    }
}
