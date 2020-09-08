<?php

namespace App\Rules\Admin\Package;

use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class CheckOrderForShipper implements Rule
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
        return  Order::whereIn('id', $value)->whereIn('status', [-1, 1, 3])->first();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute isn’t in a confirmed status, is in stock or return';
    }
}
