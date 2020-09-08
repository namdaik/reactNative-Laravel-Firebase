<?php

namespace App\Http\Requests\Admin\Staff;

use App\Rules\Admin\CheckInputRolesRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffManagerRequest extends FormRequest
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
            'is_active' => 'required|boolean',
            'roles' => ['sometimes', new CheckInputRolesRule()]
        ];
    }
}
