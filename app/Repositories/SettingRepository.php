<?php

namespace App\Repositories;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class SettingRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method SettingRepository findWithoutFail($id, $columns = ['*'])
 * @method SettingRepository find($id, $columns = ['*'])
 * @method SettingRepository first($columns = ['*'])
 */
class SettingRepository extends BaseRepository
{
    
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'key',
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
        return Setting::class;
    }

    public function checkSettingStatus($request)
    {
        $userId  = \Helper::getUserId();
        $restaurantId  = \Helper::getCartItemsRestaurantId($userId);
        $setting =  Setting::where('key', $request->setting_name)->where('restaurant_id', $restaurantId)->first();
        $data = [] ;
        if(!empty($setting)){
            if($setting->value == '1' || $setting->value == "true"){
                $data = ['status' => false, 'name' => $setting->key];
            }else{
                $data = ['status' => true, 'name' => $setting->key];
            }
        }
        return $data;
    }

    public function getSettingValue($key, $restaurantId)
    {
        $setting =  Setting::where('key', $key)->where('restaurant_id', $restaurantId)->first();
        return $setting->value;
    }

}
