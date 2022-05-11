<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\ACustomFormRequest;

class RegisterFormRequest extends ACustomFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize () : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules () : array
    {
        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'phone'      => 'required',
            'address'    => 'required',
            'password'   => 'required',
        ];
    }
}
