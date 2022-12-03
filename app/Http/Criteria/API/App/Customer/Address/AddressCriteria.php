<?php
namespace App\Http\Criteria\API\App\Customer\Address;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class AddressCriteria implements CriteriaInterface {

    /**
     * @var array
     */
    private $request;

    /**
     * AddressCriteria Constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function apply($model, RepositoryInterface $repository)
    {
        
        return $model->where('user_id', \Helper::getUserId());
    }
}