<?php

namespace App\Rules\Admin\Package;

use Illuminate\Contracts\Validation\Rule;

class CheckOrderReturnRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($order_ids)
    {
        $this->order_ids = $order_ids;
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
        return !array_diff($value, $this->order_ids);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not allowed to return';
    }
}
