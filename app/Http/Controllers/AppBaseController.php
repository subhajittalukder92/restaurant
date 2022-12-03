<?php

namespace App\Http\Controllers;


use Response;
use InfyOm\Generator\Utils\ResponseUtil;
use App\Http\Controllers\Controller as LaravelController;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends LaravelController
{
    public function sendResponse($result, $message, $extra = [])
    {
        return Response::json(array_merge(ResponseUtil::makeResponse($message, $result), $extra));
    }

    public function sendResponseArray($result, $message, $extra = [])
    {
      $result = ($result ? ($result == "[]" ? [] : $result) : json_decode("{}"));
      return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function getLangMessages($path, $name){
        if($path && $name){
            return \Lang::get($path, ['name' => $name]);
        }
        else{
            return "Success.";
        }
    }
}
