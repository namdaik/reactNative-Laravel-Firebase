<?php

namespace App\Rules\Admin\Manager;

use App\Models\TransactionPoint;
use Illuminate\Contracts\Validation\Rule;

class CheckManagerInTransactionPointRule implements Rule
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
        $transaction_point = TransactionPoint::find($value);
        return count($transaction_point->manager) == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The transaction point has manager man. Please try again';
    }
}
