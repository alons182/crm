<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClientRequest extends Request
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
            'ide' => 'numeric',
            'fullname' => 'required',
            //'phone1' => 'required|unique:clients',
            /*'company' => 'required',
            'email' => 'required|email',
            'phone1' => 'required',
            'referred' => 'required'*/
        
        ];
    }
}
