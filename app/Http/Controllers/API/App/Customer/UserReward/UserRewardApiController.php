<?php

namespace App\Http\Controllers\API\App\Customer\UserReward;

Use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRewardRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Http\Resources\API\App\Customer\UserRewardCollection;

class UserRewardApiController extends AppBaseController
{
  private $userRewardRepo;
   
  public function __construct(UserRewardRepository $userReward)
  {
      $this->userRewardRepo = $userReward;
     
  }

  /**
  *   @OA\Get(
  *     path="/api/app/customer/my-rewards",
  *      tags={"Customer App: My Rewards"}, 
  *       @OA\Response(
  *           response=200,
  *           description="Success",
  *            @OA\MediaType(
  *               mediaType="application/json",
  *           )
  *       ),
  * )
  */
  public function myReward(Request $request){
     $rewards = $this->userRewardRepo->getMyRewards();
     $totalCoin = \Helper::getTotalCoin($rewards);
     return $this->sendResponse(['item'=> UserRewardCollection::collection($rewards), 'total_coin' => $totalCoin], 'My rewards');
  }

  
}