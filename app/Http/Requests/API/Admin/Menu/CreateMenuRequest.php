<?php

namespace App\Http\Requests\API\Admin\Menu;

use Illuminate\Foundation\Http\FormRequest;

class CreateMenuRequest extends FormRequest
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
            'category_id'   => 'required|numeric',
            'name'          => 'required|max:255',
            'price'         => 'required|numeric',
            'description'   => 'required',
            'menu_type'   => 'required',
            'discount_type'   => 'nullable',
            'discount'   => 'nullable',
            'status'        => 'string|max:255',
            'photos' => 'required|max:1',
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
            'menus' => [
                'restaurant_id',
                'category_id',
                'name',
                'slug',
                'price',
                'description',
                'menu_type',
                'discount_type',
                'discount',
                'status'
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
            'category_id.required' => 'The menu category Field is required',
            'photos.max' => 'Maximum 1 files can be uploaded',
        ];
    }
}
