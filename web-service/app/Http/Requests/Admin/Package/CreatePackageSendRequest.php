<?php

namespace App\Http\Requests\Admin\Package;

use App\Rules\Admin\Package\CheckOrderForSend;
use App\Rules\Admin\Package\CheckStationOrder;
use App\Rules\Admin\Package\CheckTransactionPointrForSend;
use Illuminate\Foundation\Http\FormRequest;

class CreatePackageSendRequest extends FormRequest
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
                new CheckStationOrder(), new CheckOrderForSend()
            ],
            'next_transaction_point_id' => [
                'required',
                'exists:transaction_points,id',
                new CheckTransactionPointrForSend()
            ]
        ];
    }
}
