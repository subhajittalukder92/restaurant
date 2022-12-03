<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Reward;
use App\Models\Address;
use App\Models\Setting;
use App\Models\OrderItem;
use App\Models\UserReward;
use App\Traits\HelperTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;



/**
 * Class OrderRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method OrderRepository findWithoutFail($id, $columns = ['*'])
 * @method OrderRepository find($id, $columns = ['*'])
 * @method OrderRepository first($columns = ['*'])
 */
class OrderRepository extends BaseRepository
{
    use HelperTrait;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'invoice_id',
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
        return Order::class;
    }

    /**
     * Create a  Order.
     *
     * @param Request $request
     *
     * @return Order
     */
    public function placeOrder($request)
    {
        $userId = \Helper::getUserId();
        $restaurantId = \Helper::getCartItemsRestaurantId($userId);
        $total   = \Helper::getTotal($userId);
        $subTotal  = \Helper::getTotal($userId);
        $carts  = \Helper::getCartItems($userId);
        $address = Address::find($request->delivery_address_id) ;
        $discount = null;
        $minAmount =  \Helper::getMinAmountForFreeDelivery($restaurantId);
        $deliveryCharge =  \Helper::getDeliveryCharge($restaurantId);
        $coins = null;
        if($total >= $minAmount){
            $deliveryCharge = 0.00;
        }
        // Redeem Coin If in Request.
        if(!empty($request->redeem_coin))
        {
            $coins    = $this->getRewardCoins();
            $discount = $request->redeem_coin;
            $total    = $total - $discount ;
            $redeem   = $this->redeemCoin();
        }
        $total =  $total + $deliveryCharge ;

        DB::beginTransaction();
        $order = Order::create([
            'user_id' => $userId,
            'restaurant_id' => \Helper::getCartItemsRestaurantId($userId),
            'sub_total'    => $subTotal,
            'coins'        => $coins,
            'discount_amount'=> $discount,
            'total_amount' => $total,
            'txn_id' => $request->txn_id ?? "",
            'txn_status' => $request->txn_status ?? "",
            'payment_mode' => $request->payment_mode ?? null,
            'delivery_address' => !empty($address) ? json_encode($address) : null,
            'delivery_charge' => $deliveryCharge,
            'status' => 'pending',
        ]);
        $order->update(['order_no' => $this->getOrderNo($order->id) ]);
        
        // Order Items Save
        foreach ($carts as $key => $item) {
        
           $menu = Menu::find($item->menu_id) ;
           OrderItem::create([
               'restaurant_id' => $item->restaurant_id,
               'order_id' => $order->id,
               'menu_id'  => $item->menu_id,
               'menu_name'=> $menu->name,
               'menu_type'=> $menu->menu_type,
               'description'=> $menu->description,
               'quantity' => $item->quantity,
               'price'    => $item->rate,
               'discount' => $item->discount,
               'discount_type' => $item->discount_type,
               'total'         => $item->total,
           ]);
        }
        
        // Reward Point Save
        if($reward = $this->getReward($total)){
            $data = UserReward::create([
                    'restaurant_id' => \Helper::getCartItemsRestaurantId($userId),
                    'order_id'=> $order->id,
                    'user_id'=> \Helper::getUserId(),
                    'reward_id'=> $reward->id,
                    'amount'=> $reward->amount,
                    'coin'=> $reward->coins,
                    'status'=> 'active'
                 ]);
        }
        // Make The Cart Empty.
        Cart::where('user_id', \Helper::getUserId())->delete() ;
        DB::commit();
       
        return $order;
        //DB::rollBack();
    }

    // Get Reward Points.
    public function getReward($total)
    {
       $userId = \Helper::getUserId();
       $reward = Reward::where('restaurant_id', \Helper::getCartItemsRestaurantId($userId))->where('amount', '<=', $total)->orderBy('amount', 'desc')->first();
       return empty($reward) ? null  : $reward;
    }

    // Get Order history.
    public function orderHistory($request)
    {
      $type = $request->get('type') ?? null;
      $result = !empty($type) ? Order::where('user_id', \Helper::getUserId())->where('status',  $type)->get() 
                              : Order::where('user_id', \Helper::getUserId())->get() ;
      
      return $result;
       
    }

    // Change Order Status.
    public function changeOrderStatus($id, $request)
    {
        $order = Order::find($id);
        if(!empty($order)){
            $order->update([
                'status'=> strtolower($request->order_status),
                'delivery_notes'=> $request->delivery_notes,
            ]);
        }
       return $order;
    }

    // Assign a Delivery Boy.
    public function assignDeliveryBoy($request)
    {
        $order = Order::find($request->order_id);
        if(!empty($order)){
            $order->update([
                'delivery_boy_id'=> \Helper::getUserId(),
                'status'=> 'out_for_delivery',
            ]);
        }
       return $order;
    }

    // Redeem The Coin Value.
    public function redeemCoin()
    {
        $reward = UserReward::where(['user_id' => \Helper::getUserId(), 'status'=> 'active'])->update(array('status' => 'used'));
        return $reward;
    }

    //
    public function getRewardCoins()
    {
        $coin = UserReward::where('user_id', \Helper::getUserId())->where('status', 'active')->sum('coin');
        return $coin;
    }
  
}
