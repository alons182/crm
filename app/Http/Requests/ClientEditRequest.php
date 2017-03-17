<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ClientEditRequest extends Request
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
        $client_id = $this->input('client_id');
        
        return [
            'ide' => 'numeric',
            'fullname' => 'required',
            'phone1' => 'required|unique:clients,phone1,'. $client_id,
            'email' => 'required|email|unique:clients,email,'. $client_id,
            /*'company' => 'required',
            'email' => 'required|email',
            'phone1' => 'required',
            'referred' => 'required'*/
        
        ];
    }
}
