<?php

namespace App\Http\Resources\API\App\Customer;

use App\Models\Role;
use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressCollection extends JsonResource
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
            'id' => $this->id,
            'user_id'  => $this->user_id,
            'name'     => $this->name,
            'street'   => $this->street,
            'landmark' => $this->landmark,
            'city'     => $this->city,
            'state'    => $this->state,
            'zipcode'  => $this->zipcode,
            'country'  => $this->country,
            'contact'  => $this->contact,
        ];
    }
}
