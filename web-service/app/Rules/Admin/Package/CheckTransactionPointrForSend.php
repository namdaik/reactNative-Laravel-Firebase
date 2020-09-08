<?php

namespace App\Rules\Admin\Package;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CheckTransactionPointrForSend implements Rule
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
        return intval($value) !== $transaction_point_id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has conflict to from transaction point. Please check again.';
    }

    private function guard()
    {
        return Auth::guard('api-employee');
    }
}
