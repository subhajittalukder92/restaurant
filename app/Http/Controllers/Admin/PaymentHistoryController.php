<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;

class PaymentHistoryController extends Controller
{
    private $orderRepository;
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }
    public function index(){
        $totalSale = 0;
        $cashSale  = 0;
        $upiSale   = 0;
        // $orders = $this->orderRepository->whereNotNull('txn_id')->Where('txn_id', '<>', 'null')->orderBy('id', 'DESC')->get();
        $orders = $this->orderRepository
                        ->whereDate('created_at', date('Y-m-d'))
                        ->orderBy('id', 'DESC')->get();
        foreach ($orders as $key => $order) {
            $address = json_decode($order->delivery_address);
           $order->delivery_address = $address->street.', '.$address->landmark.', '.$address->city .', '.$address->state .', '.$address->zipcode;
           $order['date']     = \Helper::formatDateTime($order->created_at, 12);
           $order['txn_id']   = $order['txn_id'] == "null" ? "" : $order['txn_id'];
           if(strtolower($order->payment_mode) == "cash_payment"){
            $cashSale += $order->total_amount;
            }
            else if(strtolower($order->payment_mode) == "online_payment"){
                $upiSale += $order->total_amount;
            }
            $totalSale += $order->total_amount;
        }
        return view('admin.payment-history.index', ['orders' => $orders, 'cash_sale' => $cashSale, 'online_sale' =>  $upiSale , 'total_sale' => $totalSale]);
    }
    
    public function historyByDate(Request $request){
        
        $orders = $this->orderRepository->leftJoin('users', 'users.id', '=', 'orders.user_id')
        ->whereDate('orders.created_at', $request->date)
        ->orderBy('id', 'DESC')
        ->get(['orders.*','users.mobile','users.name']);
        $totalSale = 0;
        $cashSale  = 0;
        $upiSale   = 0;
        foreach ($orders as $key => $order) {
            $address = json_decode($order->delivery_address);
            $order->delivery_address = $address->street.', '.$address->landmark.', '.$address->city .', '.$address->state .', '.$address->zipcode;
           
            if(\Helper::formatDateTime($order->created_at, 3) == 'Today'){
                $order['date']  = 'Today';
            }
            else{
                $order['date'] = \Helper::formatDateTime($order->created_at, 12);
            }

            if(strtolower($order->payment_mode) == "cash_payment"){
                $cashSale += $order->total_amount;
                $order->payment_mode = 'Cash';
            }
            else if(strtolower($order->payment_mode) == "online_payment"){
                $upiSale += $order->total_amount;
                $order->payment_mode = 'Online';
            }
            else{
                $order->payment_mode = '';
            }
            $totalSale += $order->total_amount;
        }  
        $toReturn['total_sale'] =  \Helper::twoDecimalPoint($totalSale) ;
        $toReturn['cash_sale']  =  \Helper::twoDecimalPoint($cashSale) ;
        $toReturn['upi_sale']   =  \Helper::twoDecimalPoint($upiSale) ;
        $toReturn['orders']     =  $orders ;
        return $toReturn;
    }
}
