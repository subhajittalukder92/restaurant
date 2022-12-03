<?php
namespace App\Http\Criteria\API\App\Customer\MenuCategory;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class MenuCategoryCriteria implements CriteriaInterface {

    /**
     * @var array
     */
    private $request;

    /**
     * Menu Category Criteria Constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function apply($model, RepositoryInterface $repository)
    {
             
        $model =    $model->where('status', 'active');
       
        return $model;
    }
}