<?php

namespace App\Http\Controllers\API\App\Customer\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Repositories\OrderRepository;
use App\Repositories\SettingRepository;
use App\Repositories\ZipCodeRepository;
use App\Repositories\UserRewardRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\API\App\Customer\OrderCollection;
use App\Http\Requests\API\App\Customer\Order\SaveOrderApiRequest;

class OrderApiController extends AppBaseController
{
    protected $orderRepo;
    protected $settingRepo;
    protected $zipRepo;
    protected $userRewardRepo;

    public function __construct(OrderRepository $order, SettingRepository $setting, ZipCodeRepository $zipcode, UserRewardRepository $userReward)
    {
        $this->orderRepo   = $order;
        $this->settingRepo = $setting;
        $this->zipRepo = $zipcode;
        $this->userRewardRepo = $userReward;
    }

    // Place Order

	/**
	* @OA\Post(
	*     path="/api/app/customer/place-order",
	*     tags={"Customer App: Place Order"},
    *     @OA\Parameter(
    *           name="delivery_address_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ),
    *     @OA\Parameter(
    *           name="txn_id",
    *           in="query",
    *           required=false,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ),
    *     @OA\Parameter(
    *           name="txn_status",
    *           in="query",
    *           required=false,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ),
    *     @OA\Parameter(
    *           name="setting_name",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
    *     @OA\Parameter(
    *           name="redeem_coin",
    *           in="query",
    *           required=false,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
	*       ),
	*     @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       )
    * )
    */
    public function placeOrder(SaveOrderApiRequest $request)
    {
        $items = \Helper::getCartItems(\Helper::getUserId());
        if(count($items) == 0){
            return response()->json(['success' => false, 'message' => "Your cart is empty.", "cart_total"=> "0.00"], 200);
        }
        // Zipcode availability
        $address = $this->zipRepo->checkAddressAvailability($request->delivery_address_id);
        if(count($address) == 0){
            return response()->json(['success' => false, 'message' => "Sorry, delivery is not available in this zipcode", "cart_total"=> "0.00"], 200);
        }

        // Setting availability
        $setting = $this->settingRepo->checkSettingStatus($request);
        if(!isset($setting['status'])){
            return $this->sendError($this->getLangMessages('Setting name not found', 'Order'), 200);
        }
       
        if($setting['status']){
            return $this->sendError($this->getLangMessages('Sorry, '.$setting['name'].' not available now', 'Order'), 200);
        }
        $data = $this->orderRepo->placeOrder($request);
        return $this->sendResponse(new OrderCollection($data), $this->getLangMessages('Order has been placed successfully.', 'Order'));
    }


    // Order History

	/**
	* @OA\Get(
	*     path="/api/app/customer/order-history",
	*     tags={"Customer App: Order History"},
  	*     @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       )
    * )
    */
    public function orderHistory(Request $request)
    {
        $items = $this->orderRepo->orderHistory($request);
        if(count($items) == 0){
            return $this->sendError($this->getLangMessages('Sorry, No Records found.', 'Order'), 200);
        }
        
        return $this->sendResponse(["items" => OrderCollection::collection($items)], $this->getLangMessages('Order history retrieved successfully.', 'Order'));
    }



}
