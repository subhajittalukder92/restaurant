<?php

namespace App\Http\Resources\API\App\Customer;

use App\Models\Role;
use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerCollection extends JsonResource
{
    use HelperTrait;
    
    /**@keyword manager-areas-resource
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'mobile'                => $this->mobile,
            'role_id'               => $this->role_id,
            'role_name'             => !empty(Role::find($this->role_id)) ? Role::find($this->role_id)->display_name : "",
            'photo'                 => $this->getCustomerImagePath($this->id),
            'access_token'          => $this->access_token ?? "",
        ];
    }
}
