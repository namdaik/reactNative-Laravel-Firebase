<?php

namespace App\Rules\Admin\Package;

use App\Models\Employee;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CheckShipper implements Rule
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
        $shippers = Employee::whereHas('thisRoles', function ($query) use ($transaction_point_id) {
            $query->where('roles.name', '=', 'shipper');
            $query->where('employees.transaction_point_id', '=', $transaction_point_id);
        })
            ->select('id')
            ->get();
        $shipper_ids = [];
        foreach ($shippers as $shipper) {
            $shipper_ids[] = $shipper->id;
        }
        return in_array($value, $shipper_ids);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has not role shipper or not work in your transaction';
    }

    private function guard()
    {
        return Auth::guard('api-employee');
    }
}
