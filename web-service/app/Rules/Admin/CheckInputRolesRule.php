<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class CheckInputRolesRule implements Rule
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
        $role_names = ['receptionist','shipper'];
        return in_array($value,$role_names);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute only get value receptionist or shipper  .';
    }
}
