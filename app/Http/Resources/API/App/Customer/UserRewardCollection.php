<?php

namespace App\Http\Resources\API\App\Customer;

use App\Models\Service;
use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRewardCollection extends JsonResource
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
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'restaurant_id'=> $this->restaurant_id,
            'order_id'     => $this->order_id,
            'reward_id'    => $this->reward_id,
            'amount'       => $this->amount,
            'coin'         => $this->coin,
            'image'        => $this->getRewardImage($this->reward_id),
            'status'       => $this->status,
        ];
       
    }
   
}
