<?php

namespace App\Http\Resources\API\App\DeliveryBoy;

use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\App\Customer\CartCollection;
use App\Http\Resources\API\App\Customer\AddressCollection;
use App\Http\Resources\API\App\Customer\OrderedItemCollection;

class DeliverOrderCollection extends JsonResource
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
      $address = $this->getDeliveryAddress($this->delivery_address_id);
       return [
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'order_no'     => '# '.$this->order_no ?? "",
            'restaurant_id'=> $this->restaurant_id,
            'user_name'    => $this->getUser($this->user_id)->name ?? "",
            'contact_no'   => $this->getUser($this->user_id)->mobile ?? "",
            'sub_total'    => $this->total_amount,
            'tax'          => "00.00",
            'total_amount' => '₹ '.$this->total_amount,
            'order_date'   => \Helper::formatDateTime($this->created_at, 12),
            'delivery_address' => !empty($this->delivery_address) ? new AddressCollection(json_decode($this->delivery_address)) : [],
            'ordered_items'=> OrderedItemCollection::collection($this->getOrderedItems($this->id)),
            'txn_id'=> $this->txn_id ?? "",
            'txn_status'=> $this->txn_status ?? "",
            'status' => $this->orderStatus($this->status),
        ];
       
    }
   
}
