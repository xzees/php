<?php

namespace App\Repository\BBL;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\HttpManager;
use App\Repository\BBL\logPaymentRepository;
use DB;

class linkRepository extends Model
{

  public static function genLinkFromFail($data_request)
  {

    return $data_request->configuation['BASEURL']
      . ($data_request->configuation["BASEFOLDER"] == "/" ? "" : $data_request->configuation["BASEFOLDER"])
      . env('config_route')
      . env('credit_link_fail')
      . '?brandIdentifier=' . $data_request->brandIdentifier;
  }
  public static function genLinkFromSuccess($data_request)
  {

    return $data_request->configuation['BASEURL']
      . ($data_request->configuation["BASEFOLDER"] == "/" ? "" : $data_request->configuation["BASEFOLDER"])
      . env('config_route')
      . env('credit_link_check')
      . '?brandIdentifier=' . $data_request->brandIdentifier;
  }

  public static function api_standard_retrieve_booking_url($url, $ref){
    if(strpos($url, '?') !== false) {
      $returnUrl = $url . "&orderRef=" . $ref;
    }else{
      $returnUrl = $url . "?orderRef=" . $ref;
    }
    return $returnUrl;
  }

  public static function decodeLink($url){
    return htmlspecialchars_decode ($url);
  }



}
