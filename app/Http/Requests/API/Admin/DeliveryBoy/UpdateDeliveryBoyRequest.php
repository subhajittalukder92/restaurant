<?php

namespace App\Http\Requests\API\Admin\DeliveryBoy;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryBoyRequest extends FormRequest
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
            'name'    => 'required|string|max:255',
            'email'         => 'nullable|email',
			'mobile'        => 'required|numeric',
            'password'      => 'nullable|string',
        ];
    }

    /** * Get fillable key for the attributes.
     *
     * @return array
     */
    public function fillable($key)
    {  
        $attributes = [
            'delivery_boy' => [
                'name',
                'email',
                'mobile',
                'password'
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
           
        ];
    }
}
