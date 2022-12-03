<?php

namespace App\Repositories;

use App\Models\OrderItem;
use App\Repositories\BaseRepository;

/**
 * Class OrderItemRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method OrderItemRepository findWithoutFail($id, $columns = ['*'])
 * @method OrderItemRepository find($id, $columns = ['*'])
 * @method OrderItemRepository first($columns = ['*'])
 */
class OrderItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'restaurant_id',
        'order_id',
        'menu_id',
        'quantity',
        'price',
        'discount',
        'discount_type',
        'total',
        'status',
       ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
    **/
    public function model()
    {
        return OrderItem::class;
    }

   
  
}
