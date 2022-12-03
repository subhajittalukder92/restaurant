<?php

namespace App\Http\Requests\API\Admin\Reward;

use Illuminate\Foundation\Http\FormRequest;

class CreateRewardRequest extends FormRequest
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
            'amount'         => 'required|numeric',
            'coins'         => 'required|numeric',
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
            'rewards' => [
                'restaurant_id',
                'amount',
                'coins',
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
            'amount.required' => 'The Amount Field is required',
            'coins.required' => 'The Coin Field is required',
        ];
    }
}
