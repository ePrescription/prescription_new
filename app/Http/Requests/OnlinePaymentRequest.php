<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OnlinePaymentRequest extends Request
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
        $rules = [];

        $rules['telephone'] = 'required | numeric | digits:10';
        $rules['email'] = 'required | email';

        return $rules;
    }
}
