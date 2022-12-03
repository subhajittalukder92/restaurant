<?php

namespace App\Http\Controllers\API\App\DeliveryBoy\DeliverOrder;

use Carbon\Carbon;
use App\Models\Order;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Http\Controllers\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Http\Resources\API\App\DeliveryBoy\DeliverOrderCollection;
use App\Http\Criteria\API\App\DeliveryBoy\DeliverOrder\DeliverOrderCriteria;
use App\Http\Requests\API\App\DeliveryBoy\DeliverOrder\DeliverOrderApiRequest;

class DeliverOrderApiController extends AppBaseController
{
	use HelperTrait;
    protected $orderRepository;

    public function __construct(OrderRepository $order)
    {
        $this->orderRepository = $order;
    }

	// Orders

    /**
	* @OA\Get(
	*     path="/api/app/delivery-boy/orders?type={pending/delivered}&id={id}",
	*     tags={"Delivery Boy App: All Orders / Orders Based on type/ Order By Id"},
	*       @OA\Parameter(
    *           name="type",
    *           in="query",
    *           required=false,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="id",
    *           in="query",
    *           required=false,
    *           @OA\Schema(
    *               type="integer"
    *           )
    *       ),
    *       @OA\Response(
    *           response=401,
    *           description="Failure"
    *       )
    *
    * )
    */

    public function orders(Request $request)
    {
        $this->orderRepository->pushCriteria(new RequestCriteria($request));
        $this->orderRepository->pushCriteria(new LimitOffsetCriteria($request));
        $this->orderRepository->pushCriteria(new DeliverOrderCriteria($request));
        $items = $this->orderRepository->paginate($request->limit);
        
        return $this->sendResponse(['item'=> DeliverOrderCollection::collection($items), 'total' => $items->total()], '');
	}
	

	// Deliver Order.
	
	/**
    * @OA\Put(
    *     path="/api/app/delivery-boy/deliver-orders/{order-id}",
    *      tags={"Delivery Boy App: Change Status to Delivered(delivered) / Not Delivered(not_delivered) of a specific order"},
    *       @OA\Parameter(
    *           name="order_status",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="delivery_notes",
    *           in="query",
    *           required=false,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    *       @OA\Response(
    *           response=401,
    *           description="Failure"
    *       )
    *
    * )
    */
	public function changeStatus($id, DeliverOrderApiRequest $request)
	{
        $order = $this->orderRepository->findWithoutFail($id);
        if (empty($order)) {
            return $this->sendError($this->getLangMessages('Order is not found.', 'Order'), 200);
        }
        $order = $this->orderRepository->changeOrderStatus($id, $request);
        
        $message['delivered'] = "Your order is delivered successfully";
        $message['not_delivered'] = "Your order is not delivered";
        
        $status = $this->sendPush($id, $message[$request->order_status]);
        
        return $this->sendResponse(['item' => new DeliverOrderCollection($order), 'notification'=>json_decode($status)], 'Order status changed successfully.');
	}
 
	
}
