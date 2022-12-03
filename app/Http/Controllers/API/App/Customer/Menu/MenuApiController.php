<?php

namespace App\Http\Controllers\API\App\Customer\Menu;

Use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Repositories\MenuRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MenuCategoryRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use App\Http\Resources\API\App\Customer\MenuCollection;
use App\Http\Criteria\API\App\Customer\Menu\MenuCriteria;
use App\Http\Requests\API\App\Customer\Menu\MenuApiRequest;


class MenuApiController extends AppBaseController
{
  private $menuRepo;
  private $categoryRepo;
  
  public function __construct(MenuRepository $menuRepository, MenuCategoryRepository $menuCategoryRepo)
  {
      $this->menuRepo = $menuRepository;
      $this->categoryRepo = $menuCategoryRepo;
  }
  /**
  *   @OA\Get(
  *     path="/api/app/customer/menus?restaurant_id={id}&category_id={id}&user_id={id}",
  *      tags={"Customer App: Menu All"}, 
  *       @OA\Parameter(
  *           name="restaurant_id",
  *           in="query",
  *           required=true,
  *           @OA\Schema(
  *               type="Numeric"
  *           )
	*       ), 
  *       @OA\Parameter(
  *           name="category_id",
  *           in="query",
  *           required=false,
  *           @OA\Schema(
  *               type="Numeric"
  *           )
	*       ), 
  *       @OA\Parameter(
  *           name="user_id",
  *           in="query",
  *           required=false,
  *           @OA\Schema(
  *               type="Numeric"
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
    public function index(MenuApiRequest $request){
      $this->menuRepo->pushCriteria(new RequestCriteria($request));
      $this->menuRepo->pushCriteria(new LimitOffsetCriteria($request));
      $this->menuRepo->pushCriteria(new MenuCriteria($request));
      $items = $this->menuRepo->paginate($request->limit);
     
      return $this->sendResponse(['item'=> MenuCollection::collection($items), 'total' => $items->total()], '');
  }

  /**
    * @OA\Get(
    *     path="/api/app/customer/popular-menus?restaurant_id={id}&user_id={id}",
    *      tags={"Customer App: Popular Menus"},
    *       @OA\Parameter(
    *           name="restaurant_id",
    *           in="query",
    *           required=true,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
    *       ), 
    *       @OA\Parameter(
    *           name="user_id",
    *           in="query",
    *           required=false,
    *           @OA\Schema(
    *               type="Numeric"
    *           )
    *       ), 
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
  public function popularMenu(MenuApiRequest $request)
  {
      $menu = $this->menuRepo->getPopularFoods($request->restaurant_id);
     
      return $this->sendResponse(['items' => MenuCollection::collection($menu)], $this->getLangMessages('Menu is retrieved successfully', 'Menu'));
     
  }
}