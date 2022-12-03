<?php

namespace App\Http\Controllers\API\App\DeliveryBoy\ScanCode;

use Carbon\Carbon;
use App\Models\Order;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DeviceTokenRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Http\Resources\API\App\DeliveryBoy\DeliverOrderCollection;
use App\Http\Requests\API\App\DeliveryBoy\ScanCode\ScanCodeApiRequest;


class ScanCodeApiController extends AppBaseController
{
	use HelperTrait;	
    protected $orderRepository;
    protected $deviceTokenRepo;

    public function __construct(OrderRepository $order, DeviceTokenRepository $device)
    {
        $this->orderRepository = $order;
        $this->deviceTokenRepo = $device;
    }

    // Scan Order & assign Delivery Boy.
	
	/**
    * @OA\Put(
    *     path="/api/app/delivery-boy/scan-code",
    *      tags={"Delivery Boy App: Scan Code & Assign Delivery Boy to a Specific Order"},
    *       @OA\Parameter(
    *           name="order_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="integer"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="delivery_boy_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="integer"
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
	public function scanCode(ScanCodeApiRequest $request)
	{
        $order = $this->orderRepository->findWithoutFail($request->order_id);
        if (empty($order)) {
            return $this->sendError($this->getLangMessages('Order is not found.', 'Order'), 200);
        }
        $order = $this->orderRepository->assignDeliveryBoy($request);
        $message = "Your order is out for delivery";
        $status = $this->sendPush($request->order_id, $message);
        return $this->sendResponse(['item' => new DeliverOrderCollection($order), 'notification'=>json_decode($status)], 'Order status changed successfully.');
	}
 
    

}
