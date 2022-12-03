<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Zipcode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class ZipCodeRepository
 * @package App\Repositories
 * @version November 6, 2018, 9:09 am UTC
 *
 * @method ZipCodeRepository findWithoutFail($id, $columns = ['*'])
 * @method ZipCodeRepository find($id, $columns = ['*'])
 * @method ZipCodeRepository first($columns = ['*'])
 */
class ZipCodeRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'restaurant_id',
        'zipcode',
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
        return Zipcode::class;
    }

    public function checkZipcode($request)
    {
       $data = $this->where('restaurant_id', $request->restaurant_id)->where('zipcode', $request->zipcode)->get(['id','zipcode']);
       return $data;
    }
    public function checkZipcodeStatus($request)
    {
       $data = $this->where('zipcode', $request->zipcode)->get(['id','zipcode']);
       return $data;
    }

    public function checkAddressAvailability($addressId)
    {
       $userId  = \Helper::getUserId();
       $restaurantId  = \Helper::getCartItemsRestaurantId($userId);
       $address = Address::find($addressId);
       
       $data = $this->where('restaurant_id', $restaurantId)->where('zipcode', $address->zipcode)->get(['id','zipcode']);
       return $data;
    }

   
}
