<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Repositories\OrderRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\MediaRepository;
Use App\Http\Controllers\AppBaseController;
use Flash;
use Hash;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\HelperTrait;
use App\Traits\UploaderTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;
class OrderController extends AppBaseController
{
   use HelperTrait;    
   private $orderRepository;
   private $orderItemRepository;
   private $mediaRepository;

   public function __construct(
       OrderRepository $orderRepo,
       OrderItemRepository $orderItemRepo,
       MediaRepository $mediaRepo
   )
   {
       $this->orderRepository = $orderRepo;
       $this->orderItemRepository = $orderItemRepo;
       $this->mediaRepository = $mediaRepo;
   }

   public function index(Request $request){
    $orders = $this->orderRepository->orderBy('id', 'DESC')->get();
    foreach ($orders as $key => $order) {
        $address = json_decode($order->delivery_address);
       $order->delivery_address = $address->street.', '.$address->landmark.', '.$address->city .', '.$address->state .', '.$address->zipcode;
      
        $order['status'] = $this->orderStatus($order->status);
    }
   
    return view('admin.order.index', ['orders' => $orders]);
   }

   public function show($id)
   {
    $order = $this->orderRepository->findOrFail($id);  
    $order_items = $this->orderItemRepository->where('order_id', $id)->get();
    $total = 0 ;
    $billingTotal = 0 ;
    foreach ($order_items as $key => $item) {
        $billingTotal += ($item->quantity * $item->price) ;
        $total += $item->total ;
        
    }
    $billingTotal = \Helper::twoDecimalPoint($billingTotal);
    $totalDiscount = \Helper::twoDecimalPoint($billingTotal - $total) ;
    \DNS2D::getBarcodePNGPath($id, 'PDF417');
    $barcode =  url('storage/barcodes/'.$id.'pdf417.png');
    $order['payment_mode']= $this->getPaymentMode($order['payment_mode']);
    if(!empty($order->delivery_address)){
        $deliveryAddress = json_decode($order->delivery_address, true);
        if(count($deliveryAddress) > 0){
         $order->delivery_address = $deliveryAddress['name'].', '.
                                    $deliveryAddress['street'].', '.
                                    $deliveryAddress['landmark'].', '. 
                                    $deliveryAddress['city'].', '. 
                                    $deliveryAddress['state'].', '. 
                                    $deliveryAddress['zipcode'].', '. 
                                    $deliveryAddress['country'];
        }
     } 

    return view('admin.order.show', ['order' => $order, 'order_items' => $order_items, 'barcode' => $barcode, 'billing_total'=> $billingTotal, 'total_discount'=> $totalDiscount]);
   }

   public function searchOrder(Request $request){
   
    $orders = $this->orderRepository->leftJoin('users', 'users.id', '=', 'orders.user_id')
                                   ->whereDate('orders.created_at', '>=', $request->fromDate)
                                   ->whereDate('orders.created_at', '<=', $request->toDate)
                                   ->orderBy('id', 'DESC')
                                   ->get(['orders.*','users.mobile','users.name']);

    foreach ($orders as $key => $order) {
        $address = json_decode($order->delivery_address);
        $order->delivery_address = $address->street.', '.$address->landmark.', '.$address->city .', '.$address->state .', '.$address->zipcode;
        $order['status'] = $this->orderStatus($order->status);
        $order['date']   = \Helper::formatDateTime($order->created_at, 12);
    }  
    return $orders;

   }
}
