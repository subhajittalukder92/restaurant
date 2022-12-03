<?php

namespace App\Http\Controllers\API\App\Customer\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Http\Controllers\AppBaseController;


class SettingApiController extends AppBaseController
{
    protected $settingRepo;

    public function __construct(SettingRepository $setting)
    {
        $this->settingRepo = $setting;
    }

    /**
    *  @OA\Get(
    *     path="/api/app/customer/settings/{restaurant-id}",
	*      tags={"Customer App: All Settings"},
    *       @OA\Response(
    *           response=200,
    *           description="Success",
    *            @OA\MediaType(
    *               mediaType="application/json",
    *           )
    *       ),
    * )
	*/
    public function setting($id, Request $request)
    {
        $settings = $this->settingRepo->where('restaurant_id', $id)->get(['key','value']);
        $data = [];
        if(count($settings) > 0){
            foreach ($settings as $key => $setting) {
                if($setting->value == '1'){
                    $data[$setting->key] = true;
                }
                else if($setting->value == '0'){
                    $data[$setting->key] = false;
                }else{
                    $data[$setting->key] = $setting->value;
                }
                
            }
        }
        
        return $this->sendResponse($data, $this->getLangMessages('All Settings.', 'Setting'));
    }
}
