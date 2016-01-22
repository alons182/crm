<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PropertyEditRequest extends Request
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
        $property_id = $this->input('property_id');

        return [
            'name' => 'required|unique:properties,name,'.$property_id,
            'price' =>'required',
            'province' =>'required',
            'address' =>'required',
            'rooms' =>'required',
            'owner' =>'required',
            'owner_phone1' =>'required',
            'owner_email' => 'required|email'
        ];
    }
}
