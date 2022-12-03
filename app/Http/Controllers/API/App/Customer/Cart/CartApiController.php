<?php

namespace App\Http\Controllers\API\App\Customer\Cart;

use App\Models\Menu;

use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\API\App\Customer\CartCollection;
use App\Http\Requests\API\App\Customer\Cart\CartApiRequest;
use App\Http\Requests\API\App\Customer\Cart\AddCartApiRequest;
use App\Http\Requests\API\App\Customer\Cart\UpdateCartApiRequest;


class CartApiController extends AppBaseController
{
    use HelperTrait;
    protected $cartRepo;

    public function __construct(CartRepository $cart)
    {
        $this->cartRepo = $cart;
    }

    /**
    *   @OA\Get(
    *     path="/api/app/customer/carts?user_id={id}",
	*      tags={"Customer App: View Cart"},
    *       @OA\Parameter(
    *           name="user_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ), 
	*       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    * )
	*/
    public function index(CartApiRequest $request)
    {
        $items = $this->cartRepo->viewCart($request->get('user_id'));
        if(count($items) == 0){
            return response()->json(['success' => false,'message' => "Your cart is empty.", "cart_total"=> "0.00"], 200);
        }
        $total = \Helper::getTotal($request->get('user_id'));
        $restaurantId = \Helper::getCartItemsRestaurantId($request->get('user_id'));
        $minAmount =  \Helper::getMinAmountForFreeDelivery($restaurantId);
        $deliveryCharge =  \Helper::getDeliveryCharge($restaurantId);
        $savings    = \Helper::getSavingsOnCart($items);
        if($total >= $minAmount){
            $deliveryCharge = 0.00 ;
        }
        $finalTotal = $total + $deliveryCharge ;
        
        
        return $this->sendResponse(['items'=> CartCollection::collection($items), 'savings'=> \Helper::twoDecimalPoint($savings), 'item_total'=> \Helper::twoDecimalPoint($total), 'cgst'=>'00.00', 'sgst'=>'00.00', 'igst'=>'00.00', 'delivery_charge'=> floatval($deliveryCharge), 'cart_total'=> \Helper::twoDecimalPoint($finalTotal) ,'cart_total_show'=> '₹ '.\Helper::twoDecimalPoint($finalTotal) , 'item_count'=> count($items)], $this->getLangMessages('Cart data is retrieved successfully.', 'Cart'));
       
    }
    
    // Add Cart


	 /**
	* @OA\Post(
	*     path="/api/app/customer/carts",
	*     tags={"Customer App: Add to cart"},
    *      @OA\Parameter(
    *           name="menu_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ),
    *       @OA\Parameter(
    *           name="user_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ),
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       )
    * )
    */
    public function store(AddCartApiRequest $request)
    {
        $restaurantId = \Helper::getCartItemsRestaurantId($request->user_id);
        $menu = Menu::find($request->menu_id);
        //return $menu->restaurant_id;
        if($menu->status != "active"){
            return $this->sendError($this->getLangMessages('This menu is not available right now.', 'Cart'), 200);
        }
        if($restaurantId != null && ($menu->restaurant_id != $restaurantId))
        {
             return $this->sendError($this->getLangMessages('Multiple restaurant\'s menu add not allowed', 'Cart'), 200);
           
        }
       
        $data = $this->cartRepo->addToCart($request);
        $items = $this->cartRepo->viewCart($request->user_id);
        $total = \Helper::getTotal($request->user_id);
        return $this->sendResponse(['items'=> CartCollection::collection($items), 'cart_total'=> \Helper::twoDecimalPoint($total), 'cart_total_show'=> '₹ '.\Helper::twoDecimalPoint($total),  'item_count'=> count($items)], $this->getLangMessages('Menu added to cart successfully.', 'Menu'));
       
      
    }

    /**
	* @OA\Put(
	*     path="/api/app/customer/update-cart",
	*     tags={"Customer App: Update cart"},
    *       @OA\Parameter(
    *           name="menu_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ),
    *       @OA\Parameter(
    *           name="user_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ),
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       )
    * )
    */
    public function updateCart(UpdateCartApiRequest $request)
    {
        $userId = $request->user_id ;
        $data = $this->cartRepo->where('user_id', $userId)->where('menu_id', $request->menu_id)->first();
        if(empty($data)){
            return $this->sendError($this->getLangMessages('Menu does not found', 'Menu'), 200);
        }
        $data = $this->cartRepo->updateCart($request);
        $total = \Helper::getTotal($userId);
        $items = $this->cartRepo->viewCart($userId);

        return $this->sendResponse(['items'=> CartCollection::collection($items), 'cart_total'=> \Helper::twoDecimalPoint($total), 'cart_total_show'=> '₹ '.\Helper::twoDecimalPoint($total), 'item_count'=> count($items)], $this->getLangMessages('Menu updated to cart successfully.', 'Menu'));
    
       
    }

    /**
	* @OA\Get(
	*     path="/api/app/customer/menus-status",
	*     tags={"Customer App: Check Cart Menus Status"},
  	*     @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       )
    * )
    */
    public function menusStatus(Request $request)
    {
        $userId = \Helper::getUserId() ;
        $items  = \Helper::getCartItems($userId);
        if(count($items) == 0){
            return response()->json(['success' => false, 'message' => "Your cart is empty.", "cart_total"=> "0.00"], 200);
        }
        $data = $this->cartRepo->where('carts.user_id', $userId)->leftJoin('menus', 'menus.id', '=', 'carts.menu_id')
                ->where('menus.status', '<>', 'active')->get(['carts.*']);
               
        if(count($data) > 0){
            return response()->json(['success' => false, 'data' => ["items" => CartCollection::collection($data)], 'message' => "The following items are not available right now."], 401);
        }
        return $this->sendResponse(["items" => []], $this->getLangMessages('All Items are available.', 'Cart'));
    }
}
