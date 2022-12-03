<?php

namespace App\Repositories;

use App\Models\OrderFeedback;
use App\Repositories\BaseRepository;

/**
 * Class OrderFeedbackRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method OrderFeedbackRepository findWithoutFail($id, $columns = ['*'])
 * @method OrderFeedbackRepository find($id, $columns = ['*'])
 * @method OrderFeedbackRepository first($columns = ['*'])
 */
class OrderFeedbackRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'order_id',
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
        return OrderFeedback::class;
    }

   
  
}
