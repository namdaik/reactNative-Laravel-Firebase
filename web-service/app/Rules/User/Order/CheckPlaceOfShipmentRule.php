<?php

namespace App\Rules\User\Order;

use App\Models\PlaceOfShipment;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CheckPlaceOfShipmentRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        $user_id = Auth::user()->id;;
        $place_of_shipment = PlaceOfShipment::where('user_id', $user_id)
            ->where('id', $value)
            ->first();
        return !empty($place_of_shipment);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute belong to you. Please check again.';
    }
}
