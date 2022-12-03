<?php

namespace App\Http\Requests\API\Admin\Zipcode;

use Illuminate\Foundation\Http\FormRequest;

class CreateZipCodeRequest extends FormRequest
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
            'zipcode'   => 'required|string|max:10',
           
        ];
    }

    /** * Get fillable key for the attributes.
     *
     * @return array
     */
    public function fillable($key)
    {  
        $attributes = [
            'zipcode' => [
                'restaurant_id',
                'zipcode',
            ]
        ];
        return $attributes[$key];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'zipcode.required' => 'The zipcode field is required',
            
        ];
    }
}
