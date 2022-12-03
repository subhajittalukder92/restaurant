<?php

namespace App\Http\Controllers\API\App\Customer\Zipcode;

use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ZipCodeRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\App\Customer\Zipcode\ZipCodeApiRequest;


class ZipCodeApiController extends AppBaseController
{
    use HelperTrait;
    protected $zipRepo;

    public function __construct(ZipCodeRepository $zipcode)
    {
        $this->zipRepo = $zipcode;
    }

    /**
    *   @OA\Post(
    *     path="/api/app/customer/check-zipcode",
	*      tags={"Customer App: Check Zipcode By Restaurant Id"},
    *       @OA\Parameter(
    *           name="restaurant_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="numeric"
    *           )
	*       ), 
    *       @OA\Parameter(
    *           name="zipcode",
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
    public function checkZipcode(ZipCodeApiRequest $request)
    {
        $items = $this->zipRepo->checkZipcode($request);
        if(count($items) == 0){
            return $this->sendError($this->getLangMessages('Sorry, delivery is not available in this zipcode', 'Zipcode'), 200);
        }
        return $this->sendResponse($items, $this->getLangMessages('Delivery is available in this zipcode.', 'Zipcode'));
    }
}
