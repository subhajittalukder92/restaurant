<?php

namespace App\Http\Resources\API\App\Customer;

use App\Models\Service;
use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CartCollection extends JsonResource
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
      $menu = $this->getMenuById($this->menu_id);
       return [
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'menu_id'   => $this->menu_id,
            'menu_name' => !empty($menu) ? $menu->name : "",
            'description' =>  !empty($menu) ? $menu->description : "",
            'menu_type' =>  !empty($menu) ? $menu->menu_type : "",
            'menu_status' =>  !empty($menu) ? $menu->status : "",
            'image'     => $this->getMenuImage($this->menu_id),
            'quantity'  => $this->quantity,
            'rate'      => '₹ '.$this->rate,
            'is_discounted' => $this->discount > 0 ? true : false,
            'discounted_price' => '₹ '.\Helper::twoDecimalPoint(\Helper::getDiscountedPrice($this->rate, $this->discount, $this->discount_type)),
            'discount'  => strval((int)$this->discount),
            'discount_type' => $this->discount_type ?? "",
            'sub_total' => '₹ '.\Helper::twoDecimalPoint($this->quantity * $this->rate),
            'total'     => '₹ '.\Helper::twoDecimalPoint($this->quantity * \Helper::getDiscountedPrice($this->rate, $this->discount, $this->discount_type)),
        ];
       
    }
   
}
