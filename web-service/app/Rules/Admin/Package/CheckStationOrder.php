<?php

namespace App\Rules\Admin\Package;

use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CheckStationOrder implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $transaction_point_id = $this->guard()->user()->transaction_point_id;
        foreach ($value as $order) {
            return Order::findOrFail($order)->transaction_point_id == $transaction_point_id;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute have no shipping rights ';
    }

    private function guard()
    {
        return Auth::guard('api-employee');
    }
}
