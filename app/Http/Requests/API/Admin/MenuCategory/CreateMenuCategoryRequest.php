<?php

namespace App\Http\Requests\API\Admin\MenuCategory;

use Illuminate\Foundation\Http\FormRequest;

class CreateMenuCategoryRequest extends FormRequest
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
            'name'          => 'required|max:255',
            'description'   => 'required',
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
            'menu_categories' => [
                'restaurant_id',
                'name',
                'slug',
                'description',
                'status',
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
            'photos.max' => 'Maximum 1 files can be uploaded',
        ];
    }
}
