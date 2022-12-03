<?php

namespace App\Http\Resources\API\App\Customer;

use App\Models\Role;
use App\Traits\HelperTrait;
use App\Models\MenuCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuCollection extends JsonResource
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
        $userId = $request->get('user_id') ?? null;
        // return parent::toArray($request);
        $category = MenuCategory::find($this->category_id) ;
        return [
            'id'      => $this->id,
            'category_id' => $this->category_id,
            'category_name' => !empty($category) ? $category->name : "",
            'restaurant_id' => $this->restaurant_id ?? "",
            'cart_qnty'=> $this->getCartQnty($userId, $this->id),
            'name'  => $this->name,
            'slug'  => $this->slug,
            'menu_type'  => $this->menu_type ?? "",
            'description'=> $this->description ?? "",
            'image'      => $this->getMenuImage($this->id),
            'is_discounted' => $this->discount > 0 ? true : false,
            'price'      => '₹ '.$this->price,
            'discount'   => strval((int)$this->discount),
            'discounted_price' => isset($this->discount) ? '₹ '.\Helper::twoDecimalPoint(\Helper::getDiscountedPrice($this->price, $this->discount, $this->discount_type)) : '₹ '.$this->price,
            'discount_type' => $this->discount_type ?? "",
            'status'     => $this->status,
           
        ];
    }
}
