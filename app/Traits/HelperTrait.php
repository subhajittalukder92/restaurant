<?php

namespace App\Traits;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\User;
use App\Models\Media;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\Restaurant;
use App\Models\DeviceToken;
use App\Models\OrderFeedback;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

trait HelperTrait
{
    // Profile Photo path.
	public function getCustomerImagePath($id)
	{
		$image = Media::where('table_id', $id)->where('table_name', 'users')->first();

		return empty($image) ? "" :  URL::to(Storage::url($image->path));
	}

    // MenuCategory Image path.
	public function getMenuCategoryImage($id)
	{
		$image = Media::where('table_id', $id)->where('table_name', 'menu_categories')->first();

		return empty($image) ? "" :  URL::to(Storage::url($image->path));
	}

    // Menu Image path.
	public function getMenuImage($id)
	{
		$image = Media::where('table_id', $id)->where('table_name', 'menus')->first();

		return empty($image) ? "" :  URL::to(Storage::url($image->path));
	}

    // Menu Image path.
	public function getRewardImage($id)
	{
		$image = Media::where('table_id', $id)->where('table_name', 'rewards')->first();

		return empty($image) ? "" :  URL::to(Storage::url($image->path));
	}

	public function getSliderImage($id)
	{
		$image = Media::where('table_id', $id)->where('table_name', 'sliders')->first();

		return empty($image) ? "" :  URL::to(Storage::url($image->path));
	}

	// Ordered Items
	public function getOrderedItems($id)
	{
		$items = OrderItem::where('order_id', $id)
				->get(['order_items.id','order_items.menu_id', 'order_items.menu_name', 'order_items.description','order_items.menu_type',
						'order_items.quantity','order_items.price AS rate','order_items.discount','order_items.discount_type',
						'order_items.total','order_items.status',
			]);
		foreach ($items as $key => $item) {
			$item['sub_total'] = \Helper::twoDecimalPoint($item->quantity *  $item->rate);
			$item['image'] = $this->getMenuImage($item->menu_id);
			$item['status'] = $item->status ?? "";
			$item['total'] = \Helper::twoDecimalPoint($item->total) ;
		}
		return count($items) > 0 ? $items :  "";
	}

	// User Name
	public function getUser($id)
	{
		$user = User::find($id);
		return empty($user) ? "" :  $user;
	}

	// Address
	public function getDeliveryAddress($id)
	{
		$address = Address::find($id);
		return empty($address) ? "" :  $address;
	}

	// Restaurant
	public function getRestaurant($id)
	{
		$restaurant = Restaurant::find($id);

		return empty($restaurant) ? "" :  $restaurant ;
	}
	
	// Menu
	public function getMenuById($id)
	{
		$menu = Menu::find($id);
		return empty($menu) ? null :  $menu ;
	}

	// Menu
	public function getCartQnty($userId, $menuId)
	{
		$qnty = 0;
		$cart = Cart::where('user_id', $userId)->where('menu_id', $menuId)->first();
		if(!empty($cart)){
			$qnty = $cart->quantity ;
		}
		return $qnty ;
	}

	// Order Feedback
	public function getFeedback($orderId)
	{
		$feedback =	OrderFeedback::where('order_id', $orderId)->first();
		return empty($feedback) ? null : $feedback;
	}
	// Savings Amount
	public function getSavingsAmount($items)
	{
		$savings = 0;$subTotal=0;$total=0;
		if(count($items) > 0){
			foreach ($items as $key => $item) {
				$subTotal += (double) $item->sub_total ;
				$total    += (double) $item->total ;
			}
		$savings =( $subTotal - $total ) ;
		
		}
		return $savings;
	}

	// Order Status
	public function orderStatus($key)
	{
		$status = array(
			'delivered' => 'Delivered',
			'pending'   => 'Pending',
			'out_for_delivery'   => 'Out for delivery',
			'not_delivered'   => 'Not delivered',
		);
		return !empty($status[$key]) ? $status[$key] : "";
	}

	// To send push notification.
	public function sendPush($orderId, $message)
	{
		$order = Order::find($orderId);
		$userId = $order->user_id;
		$title = 'Order Status';
		$to_app = 'customer';
		$deviceTokens = [];

		$deviceToken = DeviceToken::where(['user_id' => $userId])->first();
	
		if (!empty($deviceToken)) {
		
			if ($deviceToken->device_type == "android") {
				$deviceTokens['device_token_android'] = [$deviceToken->device_token];
			}
			if ($deviceToken->device_type == "ios") {
				$deviceTokens['device_token_ios'] = [$deviceToken->device_token];
			}
			$params = [
					'type' => 'xxx',
			];
			if (count($deviceTokens) > 0) {
			$status = \Helper::sendPushNotification($to_app, $deviceTokens, $message, $title, $params);
			return $status;
			} 
		}
		else{
			return false;
		}
	}
	
	// To Insert or Update Device Token. 
    public function updateDeviceToken($userId, $newToken, $deviceType)
    {
        $data = $this->deviceTokenRepo->where(['user_id' => $userId])->first();
        if(!empty($data)){
            if($data->device_token != $newToken){
              $data->update(['device_type'=> $deviceType , 'device_token'=> $newToken]);
            }
        }else{
        $data =   $this->deviceTokenRepo->create([
                    'user_id' => $userId,
                    'device_type'=> $deviceType ,
                    'device_token' => $newToken
                ]);
       }
       return $data;
    }

	// Get Next order no
	public function getOrderNo($invoideNo)
	{
		$orderNo = str_pad($invoideNo, 10, '0', STR_PAD_LEFT);
		return $orderNo;
	}

	// Payment Mode
	public function getPaymentMode($key)
	{
		$mode =['online_payment' => 'Online payment', 'cash_payment' => 'Cash payment'];
		return array_key_exists($key, $mode) ? $mode[$key] : "";
	}
	
}
