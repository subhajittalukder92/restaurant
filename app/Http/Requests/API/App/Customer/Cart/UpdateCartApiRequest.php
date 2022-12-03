<?php

namespace App\Http\Requests\API\App\Customer\Cart;

use InfyOm\Generator\Request\APIRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Auth;

class UpdateCartApiRequest extends APIRequest
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
            'menu_id' => 'required|numeric',
            'user_id' => 'required|numeric|exists:users,id',
        ];
    }

    /** * Get fillable key for the attributes.
     *
     * @return array
     */
    public function fillable($key)
    {   

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
        /*$input  = $this->all();
        $this->getInputSource()->replace($input);
        return parent::getValidatorInstance();*/
        $input  = $this->all();
        if(empty($input)){
            $input = (array) (json_decode($this->getContent()));
        }
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
