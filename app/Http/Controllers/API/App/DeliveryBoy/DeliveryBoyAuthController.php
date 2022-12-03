<?php

namespace App\Http\Controllers\API\App\DeliveryBoy;

Use App\Http\Controllers\AppBaseController;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Media;
use App\Mail\DemoMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\UploaderTrait;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\API\App\Customer\CustomerCollection;
use App\Http\Requests\API\App\DeliveryBoy\Profile\UpdateProfieApiRequest;

class DeliveryBoyAuthController extends AppBaseController
{
    use UploaderTrait;
    private $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

  	// Edit Profile

	/**
    *   @OA\Put(
    *     path="/api/app/delivery-boy/edit-profile",
	*      tags={"Customer App: Edit Profile"}, 
	*       @OA\Parameter(
    *           name="file",
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
	

	public function editProfile(UpdateProfieApiRequest $request)
	{
        $user     =  $this->userRepo->find(Auth::user()->id);
        if(empty($user))
        {
            return $this->sendError('Customer does not found.', 401);
        }
		$image = Media::where('table_id', $user->id)->where('table_name', 'users')->first();
        if ($request->has('file')) {
			if (!empty($image)) {
				\Storage::disk('public')->delete($image->path);
				$image->delete();
			}
			$this->uploadFile($request, $user);
		}
	
        return $this->sendResponse(new CustomerCollection($user), 'Delivery boy profile updated successfully');
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
