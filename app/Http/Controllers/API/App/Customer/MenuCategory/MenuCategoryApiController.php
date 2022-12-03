<?php

namespace App\Http\Controllers\API\App\Customer\MenuCategory;

Use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MenuCategoryRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Http\Resources\API\App\Customer\MenuCategoryCollection;
use App\Http\Criteria\API\App\Customer\MenuCategory\MenuCategoryCriteria;


class MenuCategoryApiController extends AppBaseController
{
  private $menuCategoryRepo;
  public function __construct(MenuCategoryRepository $menuCategoryRepository)
  {
      $this->menuCategoryRepo = $menuCategoryRepository;
  }
  /**
  *   @OA\Get(
  *     path="/api/app/customer/menu-categories",
  *      tags={"Customer App: MenuCategory All"}, 
  *       @OA\Response(
  *           response=200,
  *           description="Success",
  *            @OA\MediaType(
  *               mediaType="application/json",
  *           )
  *       ),
  * )
  */
    public function index(Request $request){
      $this->menuCategoryRepo->pushCriteria(new RequestCriteria($request));
      $this->menuCategoryRepo->pushCriteria(new LimitOffsetCriteria($request));
      $this->menuCategoryRepo->pushCriteria(new MenuCategoryCriteria($request));
      $items = $this->menuCategoryRepo->paginate($request->limit);
      
      return $this->sendResponse(['item'=> MenuCategoryCollection::collection($items), 'total' => $items->total()], '');
  }

  /**
    * @OA\Get(
    *     path="/api/app/customer/menu-categories/{id}",
    *      tags={"Customer App: Show Specific Menu Category"},
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
  public function show($id, Request $request){
      $menuCategory = $this->menuCategoryRepo->findWithoutFail($id);
      if (empty($menuCategory)) {
          return $this->sendError($this->getLangMessages('admin/messages.not_found', 'Menu category'));
      }

      return $this->sendResponse(new MenuCategoryCollection($menuCategory), $this->getLangMessages('Menu category retrieved successfully', 'Menu category'));
  }
}