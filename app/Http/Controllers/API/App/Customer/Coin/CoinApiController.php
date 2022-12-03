<?php

namespace App\Http\Controllers\API\App\Customer\Coin;

use App\Models\Menu;

use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRewardRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\App\Customer\Coin\CoinApiRequest;


class CoinApiController extends AppBaseController
{
    use HelperTrait;
    protected $cartRepo;
    protected $userRewardRepo;
    protected $settingRepo;

    public function __construct(UserRewardRepository $userReward, CartRepository $cart, SettingRepository $setting)
    {
        $this->cartRepo = $cart;
        $this->userRewardRepo = $userReward;
        $this->settingRepo = $setting;
    }

    /**
    *   @OA\Get(
    *     path="/api/app/customer/coin-redeem?restaurant_id={restaurant_id}",
	*      tags={"Customer App: View Redeem details"},
    *       @OA\Parameter(
    *           name="restaurant_id",
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
    public function redeemStatus(CoinApiRequest $request)
    {
        $rewards = $this->userRewardRepo->getMyRewards();
        $totalCoin = \Helper::getTotalCoin($rewards);
        $coinValue = $this->settingRepo->getSettingValue('reward_coin_value', $request->get('restaurant_id'));
        $minValue = $this->settingRepo->getSettingValue('minimum_coin_value_to_redeem', $request->get('restaurant_id'));
        return $this->sendResponse(['total_coin' => (integer) $totalCoin, 'per_coin_value'=> floatval($coinValue), 'minimum_value'=> floatval($minValue)], 'Coin redeem.');  
    }

    /**
    *   @OA\Post(
    *     path="/api/app/customer/apply-coin",
	*      tags={"Customer App: Apply Coin"},
    *       @OA\Parameter(
    *           name="retaurant_id",
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
    public function applyCoin(CoinApiRequest $request)
    {   
        // Cart Total
        $total = \Helper::getTotal(\Helper::getUserId());
        $items = $this->cartRepo->viewCart(\Helper::getUserId());
        $restaurantId = \Helper::getCartItemsRestaurantId(\Helper::getUserId());
        $minAmount =  \Helper::getMinAmountForFreeDelivery($restaurantId);
        $deliveryCharge =  \Helper::getDeliveryCharge($restaurantId);
        
        if($total >= $minAmount){
            $deliveryCharge = 0.00 ;
        }
       
        if(count($items) == 0){
            return response()->json(['success' => false,'message' => "Your cart is empty.", "cart_total"=> "0.00"], 200);
        }
        $rewards   = $this->userRewardRepo->getMyRewards();
        $totalCoin = \Helper::getTotalCoin($rewards);
        $coinValue = $this->settingRepo->getSettingValue('reward_coin_value', $request->restaurant_id);
        $discount  =  $totalCoin * $coinValue ;
        $finalTotal = $total - $discount + $deliveryCharge ;
        return $this->sendResponse(['sub_total'=> \Helper::twoDecimalPoint($total), 'total_coin'=> $totalCoin, 'coin_value'=> floatval($coinValue), 'discount_amt' => floatval($discount), 'delivery_charge'=> floatval($deliveryCharge),  'cart_total'=> \Helper::twoDecimalPoint($finalTotal) , 'item_count'=> count($items)], $this->getLangMessages('You have successfully redeemed '.$totalCoin.' coins.', 'Cart'));
       
    }
    
  


	 
}
