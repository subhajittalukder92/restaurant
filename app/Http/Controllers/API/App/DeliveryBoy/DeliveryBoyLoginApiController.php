<?php

namespace App\Http\Controllers\API\App\DeliveryBoy;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Media;
use App\Models\Order;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Traits\UploaderTrait;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DeviceTokenRepository;
use App\Http\Resources\API\App\DeliveryBoy\DeliveryBoyCollection;
use App\Http\Requests\API\App\DeliveryBoy\DeliveryBoyLoginApiRequest;



class DeliveryBoyLoginApiController extends AppBaseController
{
	use UploaderTrait, HelperTrait;
    protected $deviceTokenRepo;

    public function __construct(DeviceTokenRepository $device)
    {
        $this->deviceTokenRepo = $device;
    }
	
	// Delivery Boy Login

    /**
	* @OA\Post(
	*     path="/api/app/delivery-boy/login",
	*     tags={"Delivery Boy App: Login"},
	*       @OA\Parameter(
    *           name="mobile",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="password",
    *           in="query",
    *           required=true,
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

    public function login(DeliveryBoyLoginApiRequest $request)
    {
        $data     = \Helper::getRawJSONRequest($request->getContent());
        $mobile   = \Helper::getValueFromRawJSONRequest($data,'mobile');
        $password = \Helper::getValueFromRawJSONRequest($data,'password');

        $existingUser = false;
        $roleId = 4;

        if (!empty($mobile)) {
          $user = User::where('mobile', $mobile)->first();
        }
     
     
        if (!empty($mobile) && Auth::attempt(['mobile' => $mobile, 'password' => $password, 'role_id' => $roleId])) {
            $existingUser = true;

        }
        
        if($existingUser){
            $user = Auth::user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addYears(1);
            $user['access_token'] = $tokenResult->accessToken;
            $token->save();
            if(!empty($request->device_token) && !empty($request->device_type)){
                $this->updateDeviceToken($user->id, $request->device_token, $request->device_type);
            }
            return $this->sendResponse(new DeliveryBoyCollection($user), 'Login successfully');
        }
        return $this->sendError('Invalid mobile and/or password', 401);
	}

  
	// Dashboard

	/**
     * @OA\Get(
     *     path="/api/app/delivery-boy/dashboard",
    *      tags={"Delivery Boy App: Delivery Boy Dashboard"},
    *
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
	public function dashboard()
	{
        $userId = \Helper::getUserId();
        $order['delivery_list']     = Order::where('status', 'out_for_delivery')->where('delivery_boy_id', $userId)->count();
        $order['delivered_order']   = Order::where('status', 'delivered')->where('delivery_boy_id', $userId)->count();
        $order['total_order']       = Order::where('delivery_boy_id', $userId)->count();
        
        return $this->sendResponse(['items' => $order], 'Dashboard');
	}

	

	// Logout
	
	/**
    * @OA\Post(
    *     path="/api/app/delivery-boy/logout",
    *      tags={"Delivery Boy App: Logout"},
    *
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
	public function logout(Request $request)
	{
		$request->user()->token()->revoke();
		return response()->json(['success' => true, 'data' => [], 'message' => "Logged out successfully."], 200);
	}
 
	
}
