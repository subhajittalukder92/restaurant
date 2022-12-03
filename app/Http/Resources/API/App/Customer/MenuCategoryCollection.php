<?php

namespace App\Http\Resources\API\App\Customer;

use App\Models\Role;
use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuCategoryCollection extends JsonResource
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
            'id'    => $this->id,
            'restaurant_id' => $this->restaurant_id ?? "",
            'name'  => $this->name,
            'slug'  => $this->slug,
            'description'=> $this->description,
            'image'      => $this->getMenuCategoryImage($this->id),
            'status'     => $this->status,
        ];
    }
}
