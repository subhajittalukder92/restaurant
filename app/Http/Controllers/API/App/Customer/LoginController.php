<?php

namespace App\Http\Controllers\API\App\Customer;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Media;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Traits\UploaderTrait;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use App\Repositories\DeviceTokenRepository;
use App\Http\Resources\API\App\Customer\CustomerCollection;
use App\Http\Requests\API\App\Customer\CustomerLoginApiRequest;
use App\Http\Requests\API\App\Customer\CustomerProfieUpdateApiRequest;
use App\Http\Requests\API\App\Customer\CustomerRegistrationApiRequest;

/**
 * @OA\Info(
 *  description="",
 *  version="1.0.0",
 *  title="Customer App",
 * )
 */

class LoginController extends AppBaseController
{
	use UploaderTrait, HelperTrait;
    protected $deviceTokenRepo;

    public function __construct(DeviceTokenRepository $device)
    {
        $this->deviceTokenRepo = $device;
    }
	/**
    *   @OA\Post(
    *     path="/api/app/customer/registration",
	*      tags={"Customer App: Customer Registration"}, 
	*       @OA\Parameter(
    *           name="name",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
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
    * )
    */
	public function customerRegistration(CustomerRegistrationApiRequest $request)
    {
		$data = \Helper::getRawJSONRequest($request->getContent());
        $name  = \Helper::getValueFromRawJSONRequest($data,'name');
        $mobile     = \Helper::getValueFromRawJSONRequest($data,'mobile');
        $request['password']  = bcrypt($request['password']);
		$request['role_id']   = 5; // Customer Role id 5. 
		$user                 = User::create($request->all());
			
			if($request->has('file')){
				$this->uploadFile($request, $user);
			} 
            
      return $this->sendResponse(new CustomerCollection($user), $this->getLangMessages('admin/messages.store_success', 'Registration'));
	

	}

	// Edit Profile

	/**
    *   @OA\Put(
    *     path="/api/app/customer/edit-profile",
	*      tags={"Customer App: Edit Profile"}, 
	*       @OA\Parameter(
    *           name="name",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="mobile",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
	*       ),
	*       @OA\Parameter(
    *           name="file",
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
    * )
	*/
	

	public function editProfile(CustomerProfieUpdateApiRequest $request)
	{
        $data       = \Helper::getRawJSONRequest($request->getContent());
        $mobile     = $request->mobile;
        $name       = $request->name;
      
	    
        $user     =  User::find(Auth::user()->id);
        if(empty($user))
        {
            return $this->sendError('Customer does not found.', 401);
        }
        
        // Checking for duplicate mobile.
        /*if(!empty(User::where('mobile', $mobile)->where('id', '<>', Auth::user()->id)->first()) ){
           
            return $this->sendError('This mobile is already in use', 401);
        }*/

        $otherRoleIds = [\Helper::superAdminRoleId(), 
                         \Helper::adminRoleId(), 
                         \Helper::managerRoleId(),
                         \Helper::customerRoleId()
        ]; 

        $exisiting_user = User::where('mobile', $request->mobile)
        ->where('id', '!=', $user->id)->whereIn('role_id', $otherRoleIds)->first();

        if(!empty($exisiting_user) ){
           
            return $this->sendError('This mobile is already in use', 401);
        }

		$image = Media::where('table_id', $user->id)->where('table_name', 'users')->first();

		$user->name     = $name ??   $user->name;
		$user->mobile   = $mobile ?? $user->mobile;
		
	
		if ($request->has('file')) {
			if (!empty($image)) {
				Storage::disk('public')->delete($image->path);
				$image->delete();
			}

			$this->uploadFile($request, $user);
		}
		$user->save();
        return $this->sendResponse(new CustomerCollection($user), 'Customer profile updated successfully');
	

	}
	
	// Customer Login

    /**
	* @OA\Post(
	*     path="/api/app/customer/login",
	*     tags={"Customer App: Login"},
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

    public function login(CustomerLoginApiRequest $request)
    {
        $data     = \Helper::getRawJSONRequest($request->getContent());
        $mobile   = \Helper::getValueFromRawJSONRequest($data,'mobile');
        $password = \Helper::getValueFromRawJSONRequest($data,'password');

        $existingUser = false;
        $roleId = 5; // Customer Role Id 5

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
           
            return $this->sendResponse(new CustomerCollection($user), 'Login successfully');
        }
        return $this->sendError('Invalid mobile and/or password', 401);
	}

  
	// Logged in customer details

	/**
     * @OA\Get(
     *     path="/api/app/customer/dashboard",
    *      tags={"Customer App: Customer Dashboard"},
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
        $user = Auth::user();
	    return $this->sendResponse(new CustomerCollection($user), 'Customer data retrieved successfully');
	}

	// Profile Photo path.
	public function getUserImagePath($id)
	{
		$image = Media::where('table_id', $id)->where('table_name', 'users')->first();
		return empty($image) ? null :  URL::to(Storage::url($image->path));
	}

	// Logout
	
	/**
     * @OA\Post(
     *     path="/api/app/customer/logout",
    *      tags={"Customer App: Logout"},
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
	/**
	* @OA\Put(
	*     path="/api/app/customer/edit-password",
	*     tags={"Customer App: edit Password"},
	*       @OA\Parameter(
    *           name="password",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="string"
    *           )
    *       ),
	*       @OA\Parameter(
    *           name="confirm_password",
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
    public function resetPassword(Request $request)
	{
        $validate = Validator::make($request->all(), [
                        'password'          => 'required',
                        'confirm_password'  => 'required|same:password'
                    ]);

		if($validate->fails()) {
	             return response()->json(['status' => false, 'message' => (string) json_encode($validate->errors()),'extra'=> 'validation errors'
                    ], 200);
		}
        
        if($user = User::find(Auth::user()->id)){
            $user->password = bcrypt($request->confirm_password);
            $user->save();
            return $this->sendResponse(new CustomerCollection($user), 'Customer password updated successfully');
        }
        return $this->sendError('Customer does not found.', 401);
	}

	// File upload.
	public function uploadFile($request, $user)
	{
		if ($request->has('file')) {
			if($request->input('file')){
				$media                = $this->base64FileUpload($request->input('file'), 'users');
				$input['name']        = $media['name'];
				$input['path']        = $media['path'];
				$input['table_id']    = $user->id;
				$input['table_name']  = "users";
				$input['type']        = \File::extension($this->getFile($media['path']));
				$media                = Media::create($input);
		}
	  }
	}

    
}
