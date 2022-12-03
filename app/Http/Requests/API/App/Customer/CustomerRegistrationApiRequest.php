<?php

namespace App\Http\Requests\API\App\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\User;

class CustomerRegistrationApiRequest extends FormRequest
{
    /**
     * @keyword : manager-areas-request
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
           'name'        => 'required|string|max:255',
           'mobile'      => 'required|numeric',
		   'password'    => 'required',
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
        $input  = $this->all();
        if(empty($input)){
            $input = (array) (json_decode($this->getContent()));
        }
        $this->validMobileInput($input);
        $this->getInputSource()->replace($input);
        return parent::getValidatorInstance();
    }

    /**
     * Get the error messages for giving wrong date.
     *
     * @return array
     */

    public function validMobileInput($input){ 
        if(!empty($input)) {
         $otherRoleIds = [\Helper::superAdminRoleId(), 
                          \Helper::adminRoleId(), 
                          \Helper::managerRoleId(),
                          \Helper::customerRoleId()
         ];   
         $valid_mobile = User::where('mobile', $input['mobile'])->whereIn('role_id', $otherRoleIds)->first();
         if(!empty($valid_mobile)){
             throw new HttpResponseException(response()->json(['status' => false, 'message' => "This mobile is already in use" ], 200));
         }
       }
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
