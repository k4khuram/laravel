<?php
namespace App\Helpers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class APIHelper{

    public static function get($url,$options =[]){
        $breeds = Http::get(config('app.dog_api_ur').$url,$options);
        return $breeds;
    }

    public static function successResponse ($data  = [], $message=""){

        return response()->json(['status'=>'success','data'=>$data,"message"=>$message]);
    }

    public static function failedResponse($data  = [], $message=""){

        return response()->json(['status'=>'failed','data'=>$data,"message"=>$message]);

    }

}