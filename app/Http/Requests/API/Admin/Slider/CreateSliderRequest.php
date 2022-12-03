<?php

namespace App\Http\Requests\API\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class CreateSliderRequest extends FormRequest
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
            'position'   => 'required|max:255',
            'photos' => 'required',
            'photos.*' => 'mimetypes:image/*'
        ];
    }

    /** * Get fillable key for the attributes.
     *
     * @return array
     */
    public function fillable($key)
    {  
        $attributes = [
            'sliders' => [
                'restaurant_id',
                'position',
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
            'position.required' => 'The Slider Position Field is required',
            
        ];
    }
}
