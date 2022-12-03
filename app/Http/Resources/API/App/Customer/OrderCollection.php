<?php

namespace App\Http\Resources\API\App\Customer;

use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\App\Customer\AddressCollection;
use App\Http\Resources\API\App\Customer\OrderedItemCollection;

class OrderCollection extends JsonResource
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
      $orderedItems =  $this->getOrderedItems($this->id);
      $feedback =  $this->getFeedback($this->id) ;
       return [
            'id'           => $this->id,
            'user_id'      => $this->user_id,
            'restaurant_id'=> $this->restaurant_id,
            'coins'        => $this->coins ?? "",
            'order_no' => !empty($this->order_no) ? '# '.$this->order_no : '',
            'user_name'    => $this->getUser($this->user_id)->name ?? "",
            "cgst"         => "00.00",
            "sgst"         => "00.00",
            "igst"         => "00.00",
            "delivery_charge" => $this->delivery_charge ?? 0.00,
            'total_amount' => '₹ '.\Helper::twoDecimalPoint($this->total_amount),
            'order_date'   => \Helper::formatDateTime($this->created_at, 12),
            'delivery_address' => !empty($this->delivery_address) ? new AddressCollection(json_decode($this->delivery_address)) : [],
            'delivery_boy_id' => $this->delivery_boy_id ?? "",
            'delivery_boy_name' => "",
            'ordered_items'=> OrderedItemCollection::collection($orderedItems),
            'savings'=> \Helper::twoDecimalPoint($this->getSavingsAmount($orderedItems)),
            'txn_id'=> $this->txn_id ?? "",
            'txn_status'=> $this->txn_status ?? "",
            'status' => $this->orderStatus($this->status),
            'is_completed' => ($this->status == "delivered") ? true : false,
            'is_feedback' => !empty($feedback) ? true : false,
            'rating' => !empty($feedback) ? $feedback->rating : null,
            'feedback' => !empty($feedback) ? $feedback->feedback : "",
        ];
       
    }
   
}
