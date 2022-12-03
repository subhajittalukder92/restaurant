<?php
namespace App\Http\Criteria\API\App\DeliveryBoy\DeliverOrder;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class DeliverOrderCriteria implements CriteriaInterface {

    /**
     * @var array
     */
    private $request;

    /**
     * DeliverOrderCriteria Constructor.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('delivery_boy_id', \Helper::getUserId());
        $type  = $this->request->get('type') ?? null;
        $id    = $this->request->get('id') ?? null;
        if($type){
            $model =  $model->where('status', $type);
        }
        if($id){
            $model =  $model->where('id', $id);
        }
        return $model->orderBy('created_at', 'ASC');
    }
}