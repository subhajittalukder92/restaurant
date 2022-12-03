<?php
namespace App\Http\Criteria\API\App\Customer\Menu;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class MenuCriteria implements CriteriaInterface {

    /**
     * @var array
     */
    private $request;

    /**
     * MenuCriteria Constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function apply($model, RepositoryInterface $repository)
    {
        $sql="";
        $restaurantId  = $this->request->get('restaurant_id') ?? null;
        $categoryId    = $this->request->get('category_id') ?? null;
       
        $model =    $model->where('status', 'active');
        // Applying Restaurant & Catefory id Filter.
        $sql   =  isset($restaurantId) ? $model->where('restaurant_id', $restaurantId) : $model;
        $sql   =  isset($categoryId)   ? $sql->where('category_id', $categoryId) : $sql;

        return $sql;
    }
}