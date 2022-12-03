<?php

namespace App\Utils;


use DateTime;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use App\Models\Media;
use App\Models\Order;
use App\Models\Address;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function getUniqueId()
    {
        return md5(microtime().\Config::get('app.key'));
    }

    public static function getSliderImages($id)
    {
        $image = Media::where('table_id', $id)->where('table_name', 'sliders')->first();

		return empty($image) ? "" :  URL::to(Storage::url($image->path));
    }

    public static function splitName($name)
    {
        $name_arr = [];
        if (!empty($name)) {
            $name_arr2 = explode(" ", $name);

            $name_arr[] = trim($name_arr2[0]);
            $name_arr[] = trim(!empty($name_arr2[1]) ? substr($name, strlen($name_arr2[0]) + 1) : '');
        }

        return $name_arr;
    }

    public static function jsonDecode($string)
    {
        if (self::isJson($string)) {
            return json_decode($string);
        }

        return (array)$string;
    }

    public static function isJson($string)
    {
        if (!empty($string)) {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }

        return false;
    }

    public static function convertObjectToArray($data){
        return json_decode(json_encode($data), true);
    }

    public static function getDateDiff($start_date, $end_date){
        $date1 = date_create($start_date);
        $date2 = date_create($end_date);
        return date_diff($date1,$date2)->format("%R%a");
    }

    public static function getTimeDiff($start_time, $end_time){
        $time_diff = strtotime($end_time) - strtotime($start_time);  
        $formatted_time = date('H:i', mktime(0, 0, $time_diff));
        return $formatted_time;
    }

    public static function convertToHour($time){
        $hour = Carbon::now()->startOfDay()->addSeconds($time)->toTimeString(); 
        return $hour;
      }

    public static function getRawJSONRequest($data){
        $data = (array) self::jsonDecode($data);
        return $data;
    }

    public static function getValueFromRawJSONRequest($data, $key){
       $value = (isset($data[$key]) && !empty($data[$key])) ? $data[$key] : null;
       return $value;
    }

    public static function formatDateTime($created_at, $format = 1, $timezone_name = null){
        if (!empty($created_at)) {
            $created_at = date('Y-m-d H:i:s', strtotime($created_at));
            $d = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);

            if ($format == 1) {
                $d = $d->format('d/m/Y');
            } else if ($format == 2) {
                $d = $d->format('d/m/Y h:i:s');
            } else if ($format == 3) {
                $date = $d->format('Y-m-d');
                $today = today()->format('Y-m-d'); // Helper::today();
                $yesterday = now()->addDays(-1)->format('Y-m-d'); // Helper::yesterday();

                if ($date == $today) {
                    $d = 'Today';
                } else if ($date == $yesterday) {
                    $d = 'Yesterday';
                } else {
                    $d = $d->format('d M, Y');
                }
            } else if ($format === 4) {
                $d = $d->format('l , jS M, Y');
            } else if ($format === 5) {
                $d = $d->format('Y-m-d');
            } // October 13, 2014 11:13:00
            else if ($format === 6) {
                $d = $d->format('F d, Y H:i:s');
            } else if ($format === 7) {
                $d = $d->format('d/m/y');
            }
            else if ($format === 8) {
                $d = $d->format('g:i A');
            }
            else if ($format === 9) {
                $d = $d->format('Y-m-d');
            }
            else if ($format === 10) {
                $d = $d->format('d/m');
            }
            else if ($format === 11) {
                $d = $d->format('g:i:s A');
            }else if($format === 12){
                $d = $d->format('d M, Y g:i A');
            }else if($format === 13){
                $d = $d->format('d/m/Y h:i A');
            }else if($format === 14){
                $d = $d->format('H:i:s');
            }else if($format === 15){
                $d = $d->format('Y-m-d h:i');
            }else if ($format === 16) {
                $d = $d->format('jS M');
            }else if ($format === 17) {
                $d = $d->format('H:i');
            }else if ($format === 18) {
                $d = $d->format('l, M j, Y');
            }

            if (!empty($timezone_name)) {
                return $d . ' ' . $timezone_name;
            }

            return $d;
        }

        return '';
    }

    public static function convertToSecond($value){
        $parsed = date_parse($value);
        $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
        return $seconds;
    }

    public static function getCurrentRoleId(){
        return \Auth::user()->role_id;
    }

    public static function getUserId(){
        return \Auth::user()->id;
    }

    public static function twoDecimalPoint($number){
        return number_format((float)$number, 2, '.', '');
    }

    public static function getStringAfterGivenString($delimeter, $initialString){
        $arr = explode($delimeter, $initialString);
        if(count($arr) > 0){
          return $arr[1];
        }
        else{
           return '';
        }
    }


    /*
     *****************************************
     * METHOD USING
     *****************************************
     */

    public static function getIp() {
      foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
          if (array_key_exists($key, $_SERVER) === true) {
              foreach (explode(',', $_SERVER[$key]) as $ip) {
                  $ip = trim($ip); // just to be safe
                  if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                      return $ip;
                  }
              }
          }
      }
      return request()->ip(); // it will return server ip when no client ip found

      // return file_get_contents('https://api.ipify.org');
    }

    /*
     * Get current date and time
     */
    public static function currentDateTime()
    {
        return Carbon::now()->toDateTimeString();
    }

    /*
     * Get today
     */
    public static function today($format = 'Y-m-d')
    {
        \Log::info('Today:' . Carbon::now()->format($format));
        return Carbon::now()->format($format);
    }

    public static function yesterday($format = 'Y-m-d')
    {
        \Log::info('Yesterday:' . Carbon::now()->subDays(1)->format($format));
        return Carbon::now()->subDays(1)->format($format);
    }

    public static function dayBeforeYesterday($format = 'Y-m-d')
    {
        \Log::info('Day before Yesterday:' . Carbon::now()->subDays(2)->format($format));
        return Carbon::now()->subDays(2)->format($format);
    }

    /*
     * Current Month
     */
    public static function currentMonth($format = 'm')
    {
        return Carbon::now()->format($format);
    }

    /*
     * Last Month
    */
    public static function lastMonth($format = 'm')
    {
        return Carbon::now()->subMonth()->format($format);
    }

    /*
    * Current Year
    */
    public static function currentYear($format = 'Y')
    {
        return Carbon::now()->format($format);
    }

    /*
     * Last Year
    */
    public static function lastMonthYear($format = 'Y')
    {
        return Carbon::now()->subMonth()->format($format);
    }

    public static function firstDateOfThisMonth($format = 'Y-m-d', $date = NULL)
    {
        if (!empty($date)) {
          $d = new \DateTime($date);
          $d->modify('first day of this month');
        } else {
          $d = new \DateTime('first day of this month');
        }
        return $d->format($format);
    }


    public static function lastDateOfThisMonth($format = 'Y-m-d', $date = NULL)
    {
        if (!empty($date)) {
          $d = new \DateTime($date);
          $d->modify('last day of this month');
        } else {
          $d = new \DateTime('last day of this month');
        }
        return $d->format($format);
    }


    public static function firstDateOfLastMonth($format = 'Y-m-d')
    {
        $d = new \DateTime('first day of last month');
        return $d->format($format);
    }


    public static function lastDateOfLastMonth($format = 'Y-m-d')
    {
        $d = new \DateTime('last day of last month');
        return $d->format($format);
    }


    public static function firstDateOfThreeMonthAgo($format = 'Y-m-d')
    {
        $d = new \DateTime('first day of 3 month ago');
        return $d->format($format);
    }


    public static function lastDateOfThreeMonthAgo($format = 'Y-m-d')
    {
        $d = new \DateTime('last day of 3 month ago');
        return $d->format($format);
    }

    public static function cleanPhone($phone)
    {
        $phone = preg_replace("/[^\d]/", "", $phone);

        return $phone;
    }

    public static function cleanName($name)
    {
        if (!empty($name)) {
          $name = ucwords(str_replace('_', ' ', $name));
        }

        return $name;
    }

    /*
     * Formatting phone depending on phone
     *
     * @param phone
     *
     * @return formatted phone
     *
     */
    public static function formatPhone($phone)
    {
        $phone = preg_replace("/[^\d]/", "", $phone);

        $l = strlen($phone);
        $c = substr($phone, 0, ($l > 10 ? $l - 10 : 0));
        $p = substr($phone, $l - ($l > 10 ? 10 : $l));
        $p1 = substr($p, 0, 3);
        $p2 = substr($p, 3, 3);
        $p3 = substr($p, 6, 4);

        $ph = "";
        if ($c) {
            $ph .= '+' . $c;
        }
        if ($p1) {
            $ph .= '(' . $p1 . ') ';
        }
        if ($p2) {
            $ph .= $p2 . '-';
        }
        if ($p3) {
            $ph .= $p3;
        }

        return $ph;
    }

    // Get HH:mm:ss format from time array
    public static function getTime($data)
    {
        $date = new DateTime();
        $time = is_array($data) ? $data :  json_decode($data, true) ;

        $object = $date->setTime($time["hh"] + ($time["A"] === 'PM' ? 12 : 0), $time["mm"]);
        
        return $object->format('H:i:s');
    }
    public  static function setTimeZone($timezone)
    {
        if (!empty($timezone)) {
            date_default_timezone_set($timezone);
        }
    }
    // Get Role.
    public static function getRoleId($name){
        $role = Role::where('name', $name)->first();
        
        return ($role) ? $role->id : 0;
    }
    
    // Total Cart Amount
    public static function getTotal($userId)
    {
        $data = Cart::where('user_id', $userId)->get();
        $sum = 0;
        if(count($data) > 0){
            foreach ($data as $key => $item) {
                $price = \Helper::getDiscountedPrice($item->rate, $item->discount, $item->discount_type);
                $sum += ($item->quantity *  $price) ;
            }
        }
        
        return $sum ;

    }

    // Saving In cart Items
    public static function getSavingsOnCart($data)
    {
        $savings =0;
        if(count($data) > 0){
            foreach ($data as $key => $item) {
                $subTotal = ($item->quantity *  $item->rate);
                $price = \Helper::getDiscountedPrice($item->rate, $item->discount, $item->discount_type);
                $actualTotal   = ($item->quantity *  $price) ;
                $savings += ($subTotal -  $actualTotal) ;
            }
        }
        
        return $savings ;

    }
    
    // Calculate Discounted Price
    public static function getDiscountedPrice($originalPrice, $discount = 0, $type = NULL)
    {
        if($discount){
            if(strtolower($type) == "percentage" || strtolower($type) == "percent"){
                $originalPrice = round($originalPrice * (100 - $discount )/100 , 2);
            }else{
             
                $originalPrice = ($originalPrice - $discount);
            }
        }
        
        return $originalPrice;
    }

    // Get Cart Details
    public static function getCartItems($userId)
    {
        $data = Cart::where('user_id', $userId)->leftJoin('menus', 'menus.id', '=', 'carts.menu_id')
                ->get(['carts.*', 'menus.name AS menu_name', 'menus.description']);
        $sum = 0;
        if(count($data) > 0){
            foreach ($data as $key => $item) {
                $price = \Helper::getDiscountedPrice($item->rate, $item->discount, $item->discount_type);
                $item['total'] = ($item->quantity * $price) ;
               // $sum += ($item->quantity * $price) ;
            }
        }
        return $data;
    }

    //Get User By ID
    public static function getUser($id)
    {
        $user = User::find($id);
        return empty($user) ? "" :  $user;
    }
    //Get User By ID
    public static function getDeliveryAddress($id)
    {
        $address = Address::find($id);
		return empty($address) ? "" :  $address;
    }

    // Get User Restaurant Id.
    public static function getUserRestaurantId()
    {
        return \Auth::user()->restaurant_id;
    }

    // Get cart Items Restaurant Id.
    public static function getCartItemsRestaurantId($userId)
    {
        $data = Cart::where('user_id', $userId)->groupBy('restaurant_id')->first('restaurant_id');
        return !empty($data) ? $data->restaurant_id : null;
      
    }

    // Get Total Coin Of user.
    public static function getTotalCoin($rewards)
    {
        $totalCoin = 0;
        if(count($rewards) > 0){
            foreach ($rewards as $key => $reward) {
               $totalCoin += $reward['coin'];
            }
        }
        return $totalCoin;
    }

    public static function superAdminRoleId(){
        return config('roles.super_admin');
    }

    public static function adminRoleId(){
        return config('roles.admin');
    }

    public static function managerRoleId(){
        return config('roles.manager');
    }
   
    public static function deliveryBoyRoleId(){
        return config('roles.delivery_boy');
    }

    public static function customerRoleId(){
        return config('roles.customer');
    }

    public static function newOrders(){
      $id = \Auth::user()->restaurant_id;
      return  Order::where('status', 'pending')->where('restaurant_id', $id)->count();
    }

     // Push Notifications
     public static function sendPushNotification($to_app = null, $deviceTokens = [], $message = null, $title = '', $params = [])
     {
 
       if (empty($title))
       {
         // $title = 'New Notification';
         $title = '';
       }
 
       if (!empty($params))
       {
         $params = array_merge($params, ['to_app' => $to_app]);
       }
 
       if(is_array($deviceTokens) && sizeof($deviceTokens) > 0)
       {
         $deviceTokenAndroidArr       = !empty($deviceTokens['device_token_android']) ? $deviceTokens['device_token_android'] : [];
 
         $deviceTokenIosArr           = !empty($deviceTokens['device_token_ios']) ? $deviceTokens['device_token_ios'] : [];
 
 
         //////////////////
         // Android
         //////////////////
         if (!empty($deviceTokenAndroidArr))
         {
           $deviceTokenAndroidArr = array_unique($deviceTokenAndroidArr);
 
           // API access key from Google API's Console
           $api_access_key = 'AAAAJmKebBs:APA91bGlw9WumYUyn0jzUpL4RVzKmzfkLTHSYO4WFFL4Pd6evMZqbclCXdCHEXQmR_MuSw8WcKSz1Ubs59x1Wj6_9tTc9xild2hYlLRiV7QraKCnf2My4wdNm398GSD7VWBV0A0Y2yJq';
 
           foreach ($deviceTokenAndroidArr as $deviceTokenAndroid)
           {
             if (!empty($deviceTokenAndroid) && $deviceTokenAndroid != 'NO_DEVICE_TOKEN_FOR_IOS_SIMULATOR')
             {
               if (is_array($deviceTokenAndroid) && sizeof($deviceTokenAndroid) > 0)
               {
                 $registrationIds = $deviceTokenAndroid;
               }
               else
               {
                 $registrationIds = array($deviceTokenAndroid);
               }
 
               // prep the bundle
               $msg = array
               (
                 'message' 	=> $message,
                 'title'		=> $title,
                 //'subtitle'	=> 'Subtitle',
                 //'tickerText'	=> 'Ticker text here',
                 'vibrate'	=> 1,
                 'sound'		=> 1,
                 //'largeIcon'	=> 'large_icon',
                 //'smallIcon'	=> 'small_icon',
               );
 
               if (!empty($params))
               {
                 $msg = array_merge($msg, array('params' => $params));
               }
 
               $fields = array
               (
                 'registration_ids' => $registrationIds,
                 'data'			   => $msg
               );
 
               $headers = array
               (
                 'Authorization: key=' . $api_access_key,
                 'Content-Type: application/json'
               );
 
               $ch = curl_init();
               curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
               curl_setopt( $ch,CURLOPT_POST, true );
               curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
               curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
               curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
               curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
               $result = curl_exec($ch );
               curl_close( $ch );
 
                return $result; 
              // print_r($result);
               exit;
               //\Log::info('Push Result:: App Name: ' . $to_app . ' | Device token Android: ' . $deviceTokenAndroid . ' | Title: ' . $title . ' | Message: ' . $message . ' | Result: ' . $result);
               //echo $result;
             }
           }
         }
 
         //////////////////
         // iOS
         //////////////////
         if (!empty($deviceTokenIosArr))
         {
           
           $deviceTokenIosArr = array_unique($deviceTokenIosArr);
           foreach ($deviceTokenIosArr as $deviceTokenIos)
           {
             // echo '|' . $deviceTokenIos;
             if (!empty($deviceTokenIos) && $deviceTokenIos != 'NO_DEVICE_TOKEN_FOR_IOS_SIMULATOR' && $deviceTokenIos != 'IOS_SIMULATOR')
             {
               // *******************/
               // CUSTOMER
              // *******************/
               if ($to_app == 'customer')
               {
                 $bundleId = ''; # <- Your Bundle ID
               }
 
               // *******************/
              // DRIVER
              //*******************/
               else if ($to_app == 'driver')
               {
                 
                 $bundleId = ''; # <- Your Bundle ID
               }
 
               $production = true;
               // ***************************************************************************
               // NOTE: WE WERE USING THIS FOR SENDING PUSH NOTIFICATION BY USING .pem FILE
               // ***************************************************************************
               $keyFile  = '';               # <- Your AuthKey file
               $keyId    = '';               # <- Your Key ID
               $teamId   = '';               # <- Your Team ID (see Developer Portal)
               $url      = $production ? 'https://api.push.apple.com' : 'https://api.development.push.apple.com';  # <- development url, or use http://api.push.apple.com for production environment
               $url      = trim($url . '/3/device/' . trim($deviceTokenIos));
 
               $msg = array(
                 'title' => $title,
                 'body'  => $message,
               );
 
               if (!empty($params))
               {
                 $msg = array_merge($msg, array('params' => $params));
               }
 
               $msg = '{"aps":{"alert":'.json_encode($msg).',"sound":"cash_register_cha_ching_soundbible.aiff"}}';
 
               $key = openssl_pkey_get_private('file://'.$keyFile);
 
               $header = ['alg' => 'ES256', 'kid' => $keyId];
               $claims = ['iss' => $teamId, 'iat' => time()];
 
               $headerEncoded = $this->base64($header);
               $claimsEncoded = $this->base64($claims);
 
               $signature = '';
               openssl_sign($headerEncoded . '.' . $claimsEncoded, $signature, $key, 'sha256');
               $jwt = $headerEncoded . '.' . $claimsEncoded . '.' . base64_encode($signature);
 
               // only needed for PHP prior to 5.5.24
               if (!defined('CURL_HTTP_VERSION_2_0')) {
                   define('CURL_HTTP_VERSION_2_0', 3);
               }
 
               $headers = [
                 "apns-topic: {$bundleId}",
                 "authorization: bearer $jwt"
               ];
 
               $http2ch = curl_init();
               curl_setopt( $http2ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0 );
               curl_setopt( $http2ch, CURLOPT_URL, $url );
               curl_setopt( $http2ch, CURLOPT_PORT, 443 );
               curl_setopt( $http2ch, CURLOPT_HTTPHEADER, $headers );
               curl_setopt( $http2ch, CURLOPT_POST, true );
               curl_setopt( $http2ch, CURLOPT_POSTFIELDS, $msg );
               curl_setopt( $http2ch, CURLOPT_RETURNTRANSFER, true );
               curl_setopt( $http2ch, CURLOPT_SSL_VERIFYPEER, false );
               curl_setopt( $http2ch, CURLOPT_TIMEOUT, 30 );
               curl_setopt( $http2ch, CURLOPT_HEADER, true );
               curl_setopt( $http2ch, CURLOPT_FOLLOWLOCATION, true );
               curl_setopt( $http2ch, CURLOPT_ENCODING, "" );
               curl_setopt( $http2ch, CURLOPT_AUTOREFERER, true );
               curl_setopt( $http2ch, CURLOPT_CONNECTTIMEOUT, 120 );
               curl_setopt( $http2ch, CURLOPT_MAXREDIRS, 10 );
               $result = curl_exec($http2ch );
 
               if ($result === FALSE) {
                 echo curl_error($http2ch);exit;
                 $status = curl_error($http2ch);
               } else {
                 $status = curl_getinfo($http2ch, CURLINFO_HTTP_CODE);
               }
               curl_close( $http2ch );
 
               if(file_exists($keyFile)){
                 echo 'file exists';
               }else{
                 echo 'file not exists';
               }
               
 
               echo ' | Result: ' . $status;
               exit;
 
               //\Log::info('Push Result:: App Name: ' . $to_app . ' | Device token iOS: ' . $deviceTokenIos . ' | Title: ' . $title . ' | Message: ' . $message . ' | Result: ' . $status . $url);
             }
           }
         }
       }
 
       return ;
     }

     public static function getMinAmountForFreeDelivery($restaurantId){

       $data = Setting::where('restaurant_id', $restaurantId)->where('key','minimum_amount_for_free_delivery')->first();
       return $data->value;
                        
     }
     public static function getDeliveryCharge($restaurantId){

       $data = Setting::where('restaurant_id', $restaurantId)->where('key','delivery_charge')->first();
       return $data->value;
                        
     }
}
