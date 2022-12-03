<?php

namespace App\Http\Resources\API\App\Customer;

use App\Models\Service;
use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderCollection extends JsonResource
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
        $restaurant = $this->getRestaurant($this->restaurant_id);
       return [
            'id'       => $this->id,
            'restaurant_id' => $this->restaurant_id,
            'restaurant_name' => !empty($restaurant) ?  $restaurant->name : "",
            'position'  => $this->position,
            'image' => $this->getSliderImage($this->id),
        ];
       
    }
   
}
