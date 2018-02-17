<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FutureAppointmentRequest extends Request
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

        $rules['fromDate'] = 'required | after:today';
        $rules['toDate'] = 'required | after:fromDate';

        return $rules;
    }
}
