<?php

namespace App\Http\Requests\API\App\Customer\OrderFeedback;

use InfyOm\Generator\Request\APIRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Auth;

class CreateFeedbackApiRequest extends APIRequest
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
            'order_id' =>'required|numeric',
            'rating' =>'required|numeric',
            'feedback' =>'nullable|string|max:255',
          
        ];
    }

    /** * Get fillable key for the attributes.
     *
     * @return array
     */
    public function fillable($key)
    {   
        $attributes = [
            'feedback' => [
                'user_id',
                'order_id',
                'rating',
                'feedback',
            ]
        ];
        return $attributes[$key];
    }

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function validationData()
    {
        return $this->all();

    }

    /**
     * Get the validator instance for the request.
     *
     * @return Validator
     */
    protected function getValidatorInstance()
    {
        $input  = $this->all();
        if(empty($input)){
            $input = (array) (json_decode($this->getContent()));
        }
        $input['user_id'] = \Helper::getUserId();
        $this->getInputSource()->replace($input);
        return parent::getValidatorInstance();
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

    /**
     * Throw exception from
     *
     * @return array
     */
    protected function failedValidation(Validator $validator) {

        $errors = (new ValidationException($validator))->errors();
          throw new HttpResponseException(response()->json(['status' => false, 'message' => (string) json_encode($errors),'extra'=> 'validation errors'
          ], 200));
      }
}
