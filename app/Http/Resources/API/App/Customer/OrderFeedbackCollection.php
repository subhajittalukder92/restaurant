<?php

namespace App\Http\Resources\API\App\Customer;

use App\Models\Role;
use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderFeedbackCollection extends JsonResource
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
            'order_id' => $this->order_id,
            'rating'   => $this->rating,
            'feedback' => $this->feedback,
            'created_at'=> \Helper::formatDateTime($this->created_at, 12),
        ];
    }
}
