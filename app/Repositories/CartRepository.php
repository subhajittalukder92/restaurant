<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Menu;
use App\Repositories\BaseRepository;



/**
 * Class CartRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method CartRepository findWithoutFail($id, $columns = ['*'])
 * @method CartRepository find($id, $columns = ['*'])
 * @method CartRepository first($columns = ['*'])
 */
class CartRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'menu_id',
       ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Cart::class;
    }

    /**
     * Create a  Cart Item.
     *
     * @param Request $request
     *
     * @return Cart
     */
    public function addToCart($request)
    {
        $userId = $request->user_id ;
        $menu = Menu::find($request->menu_id);
       
        $data = Cart::where('user_id', $userId)->where('menu_id', $request->menu_id)->first();
        if(!empty($data)){
            $updatedQnty = $data->quantity + 1 ;
            $data->update(['quantity' => $updatedQnty]) ;
           
           
        }else{
           
            $data = Cart::create([
                                'restaurant_id'=> $menu->restaurant_id, 
                                'user_id'=> $userId, 
                                'menu_id'=>$request->menu_id,
                                'quantity'=> 1,
                                'discount'=> $menu->discount,
                                'discount_type'=> $menu->discount_type,
                                'rate'=> $menu->price,
                        ]);
        }
        $data['menu_name']   =  $menu->name;
        $data['description'] = $menu->description;
        $data['cart_total']  = \Helper::getTotal($userId);
        return $data;
    }

    /**
     * Update the cart Item.
     *
     * @param Request $request
     *
     * @return Cart
     */
    
    public function update($id, $request)
    {
        $userId = $request->user_id  ;
        $data   = Cart::find($id);
        $menu   = Menu::find($data->menu_id);
        $updatedQnty = $data->quantity - 1 ;
        
        if($updatedQnty > 0){
            $data->update(['quantity' => $updatedQnty]) ;
            $data['deleted'] = false;
            $data['cart_total'] = \Helper::getTotal($userId);
        }else{
            $data->delete();
            $data['deleted'] = true;
            $data['cart_total'] = \Helper::getTotal($userId);
           
        }
        $data['menu_name']   =  isset($menu) ? $menu->name : "";
        $data['description'] =  isset($menu) ? $menu->description : "";

        return $data;
    }

    // Update Cart
    public function updateCart($request)
    {
        $userId = $request->user_id  ;
        $menu = Menu::find($request->menu_id);
        $data = Cart::where('user_id', $userId)->where('menu_id', $request->menu_id)->first();
       
        $updatedQnty = $data->quantity - 1 ;
        
        if($updatedQnty > 0){
            $data->update(['quantity' => $updatedQnty]) ;
            $data['deleted'] = false;
           // $data['cart_total'] = \Helper::getTotal($userId);
        }else{
            $data->delete();
            $data['deleted'] = true;
           // $data['cart_total'] = \Helper::getTotal($userId);
           
        }
        
        return $data;
    }

    // Cart Details
    public function viewCart($userId)
    {
        $data = Cart::where('user_id', $userId)->get();
        /* $data = Cart::where('user_id', $userId)->leftJoin('menus', 'menus.id', '=', 'carts.menu_id')
                ->get(['carts.*','menus.name AS menu_name','menus.description']); */
        $sum = 0;
        /* if(count($data) > 0){
            foreach ($data as $key => $item) {
                $price = $this->getDiscountedPrice($item->rate, $item->discount, $item->discount_type);
                $item['total'] = ($item->quantity * $price) ;
                $sum += ($item->quantity * $price) ;
            }
        } */
        
        return $data ;

    }

    // Calculate Discounted Price
    public function getDiscountedPrice($originalPrice, $discount = 0, $type = NULL)
    {
        if($discount){
            if(strtolower($type) == "percentage"){
                $originalPrice = round($originalPrice * (100 - $discount )/100 , 2);
            }else{
             
                $originalPrice = ($originalPrice - $discount);
            }
        }
        
        return $originalPrice;
    }

    
    
  
}
