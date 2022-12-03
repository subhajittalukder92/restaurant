<?php

namespace App\Http\Controllers\API\App\Customer\Slider;

use App\Models\Menu;

use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SliderRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\API\App\Customer\SliderCollection;
use App\Http\Requests\API\App\Customer\Slider\SliderApiRequest;


class SliderApiController extends AppBaseController
{
    use HelperTrait;
    protected $sliderRepo;

    public function __construct(SliderRepository $slider)
    {
        $this->sliderRepo = $slider;
    }

    /**
    *   @OA\Post(
    *     path="/api/app/customer/sliders",
	*      tags={"Customer App: View Slider By Restaurant Id"},
    *       @OA\Parameter(
    *           name="restaurant_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="numeric"
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
    public function viewSlider(SliderApiRequest $request)
    {
        $items = $this->sliderRepo->getSlider($request);
        if(count($items) == 0){
            return $this->sendError($this->getLangMessages('No slider is found', 'Slider'));
        }
        return $this->sendResponse($items, $this->getLangMessages('All slider is retrieved successfully.', 'Slider'));
    }
}
