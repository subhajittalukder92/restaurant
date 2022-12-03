<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\UserReward;
use Illuminate\Support\Str;
use App\Traits\UploaderTrait;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserRewardRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method UserRewardRepository findWithoutFail($id, $columns = ['*'])
 * @method UserRewardRepository find($id, $columns = ['*'])
 * @method UserRewardRepository first($columns = ['*'])
 */
class UserRewardRepository extends BaseRepository
{
    use UploaderTrait;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'restaurant_id',
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
        return UserReward::class;
    }


    // Search Reward
    public function getMyRewards()
    {
        $result = UserReward::where('user_id', \Helper::getUserId())->where('status', 'active')->get();
        return $result;
    }
}
