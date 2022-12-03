<?php

namespace App\Http\Controllers\API\App\Customer\OrderFeedback;

Use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderFeedbackRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Http\Resources\API\App\Customer\OrderFeedbackCollection;
use App\Http\Requests\API\App\Customer\OrderFeedback\CreateFeedbackApiRequest;


class OrderFeedbackApiController extends AppBaseController
{
  private $feedbackRepo;
  
  public function __construct(OrderFeedbackRepository $feedbackRepository)
  {
      $this->feedbackRepo = $feedbackRepository;
  }

 /**
	* @OA\Post(
	*     path="/api/app/customer/create-feedback",
	*     tags={"Customer App: Create Feedback"},
  *     @OA\Parameter(
  *           name="order_id",
  *           in="query",
  *           required=true,
  *           @OA\Schema(
  *               type="Numeric"
  *           )
	*       ),
  *     @OA\Parameter(
  *           name="rating",
  *           in="query",
  *           required=true,
  *           @OA\Schema(
  *               type="Numeric"
  *           )
	*       ),
  *     @OA\Parameter(
  *           name="feedback",
  *           in="query",
  *           required=false,
  *           @OA\Schema(
  *               type="String"
  *           )
	*       ),
	*     @OA\Response(
  *           response=200,
  *           description="Success",
  *            @OA\MediaType(
  *               mediaType="application/json",
  *           )
  *       )
  * )
  */
  public function saveFeedback(CreateFeedbackApiRequest $request)
  {
    $feedback = $this->feedbackRepo->create($request->all());
    return $this->sendResponse(new OrderFeedbackCollection($feedback), 'Feedback is created successfully.');
  }
}