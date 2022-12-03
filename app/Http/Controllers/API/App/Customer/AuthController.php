<?php

namespace App\Http\Controllers\API\App\Customer;

Use App\Http\Controllers\AppBaseController;
use DB;
use Auth;
use Carbon\Carbon;
use App\Mail\DemoMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\App\Admin\AdminCollection;
use App\Http\Requests\API\App\Admin\AdminSendMailRequest;
use App\Http\Requests\API\App\Admin\ChangePassowordRequest;
use App\Http\Requests\API\App\Admin\AdminEditProfileRequest;
use App\Http\Requests\API\App\Customer\Authentication\OtpApiRequest;
use App\Http\Requests\API\App\Customer\Authentication\CheckOtpApiRequest;
use App\Http\Requests\API\App\Customer\Authentication\ResetPasswordApiRequest;



class AuthController extends AppBaseController
{
    private $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

  /**
  * @OA\Post(
  *     path="/api/app/customer/send-otp",
  *      tags={"Customer App: Forget Password: Send Otp"},
  *       @OA\Parameter(
  *           name="mobile",
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
  *       
  *
  * )
  */
  public function sendOTP(OtpApiRequest $request){
    $data     = \Helper::getRawJSONRequest($request->getContent());
    $mobile   = \Helper::getValueFromRawJSONRequest($data, 'mobile');
    $user = null;

    if (!empty($mobile)) {
        $user = $this->userRepo->where('mobile', $mobile)->first();
    }
    if (!empty($user)) {
        $token = Str::random(100).$user->id;
        $saved_data = DB::table('password_resets')->where('mobile', $user->mobile)->first();

        if(!empty($saved_data)){
            DB::table('password_resets')->where('mobile', $user->mobile)->delete();
        }

        DB::insert('insert into password_resets (mobile, token) values (?, ?)', [$user->mobile, $token]);

        return $this->sendResponse(['otp' => '0000', 'token' => $token, 'status' => true], 'OTP Sent successfully');
    }   
    return $this->sendError('Sorry! User does not exist', 401);
  }

/**
  * @OA\Post(
  *     path="/api/app/customer/check-otp",
  *      tags={"Customer App: Forget Password: Check Otp"},
  *       @OA\Parameter(
  *           name="otp",
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
  *       
  *
  * )
  */
  public function checkOTP(CheckOtpApiRequest $request)
  {
    $data = \Helper::getRawJSONRequest($request->getContent());
    $otp = \Helper::getValueFromRawJSONRequest($data,'otp');
 
    if (!empty($otp)) {
        if($otp === "0000"){
           
            return $this->sendResponse(['status' => true], 'OTP verified successfully');
        }
        else{
            return $this->sendResponse(['status' => false], 'Sorry! Wrong OTP');  
        }
       
    }
    return $this->sendError('Please send OTP', 401);
 }

/**
  * @OA\Post(
  *     path="/api/app/customer/reset-password",
  *      tags={"Customer App: Forget Password: Reset Password"},
  *       @OA\Parameter(
  *           name="password",
  *           in="query",
  *           required=true,
  *           @OA\Schema(
  *               type="string"
  *           )
  *       ),
  *       @OA\Parameter(
  *           name="token",
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
  *       
  *
  * )
  */
 public function resetPassword(ResetPasswordApiRequest $request){  
    $data     = \Helper::getRawJSONRequest($request->getContent());
    $password = \Helper::getValueFromRawJSONRequest($data,'password');
    $token    = \Helper::getValueFromRawJSONRequest($data,'token');
    $reset_data = DB::table('password_resets')->where('token', $token)->first();
    $user = null;

    if(!empty($reset_data)){
        $user = $this->userRepo->where('mobile', $reset_data->mobile)->first();
    }
    
    if((empty($password)) && (empty($token))){
        return $this->sendError('Please send password and token', 401);
    }
    else if ((!empty($password)) && (!empty($user))) { 
        $data1['password'] = \Hash::make($password);
        $user->update($data1);

        $saved_data = DB::table('password_resets')->where('mobile', $user->mobile)->first();

        if(!empty($saved_data)){
            DB::table('password_resets')->where('mobile', $user->mobile)->delete();
        }

        return $this->sendResponse(['status' => true],  "Password changed successfully");
    }
    else{
        return $this->sendResponse(['status' => false],  "Sorry! User does not exist");
    }
  }

}
