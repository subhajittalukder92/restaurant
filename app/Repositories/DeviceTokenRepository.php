<?php

namespace App\Repositories;

use App\Models\DeviceToken;
use Illuminate\Support\Facades\Hash;
use Prettus\Repository\Eloquent\BaseRepository;
/**
 * Class UserDeviceTokenRepository
 * @package App\Repositories
 * @version October 27, 2020, 10:04 am UTC
*/

class DeviceTokenRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'device_type',
        'device_token',
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
        return DeviceToken::class;
    }
}
