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
            'ide' => 'required|unique:clients|numeric',
            'fullname' => 'required',
            'company' => 'required',
            'email' => 'required|email',
            'phone1' => 'required'
        
        ];
    }
}
