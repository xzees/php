<?php

namespace App\Repository\BBL;

class apiErpRepository
{
  /**
   *  Auth Basic 
   *  @return 200 {...}
   *  @return 400 {"error":true,"message":"not found id"}
   *  @return 400 {"error":true,"message":"Authorization Required"}
   */
  public static function returnHeader(&$ch)
  {
    $headers = array(
      'Authorization: Basic ' . base64_encode(env("TSM_SECRET") . ":") // <---
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  }

  /**
   *  Call API Get cclog
   * 
   *  @return 200 {...}
   *  @return 400 {"error":true,"message":"not found id"}
   *  @return 400 {"error":true,"message":"Authorization Required"}
   * 
   */
  public static function cclog($order_code)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, env("URL_TSM") . env("query_tsm_url_cclog") . "?order_code=" . $order_code);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    apiErpRepository::returnHeader($ch);

    $output = curl_exec($ch);
    if ($errno = curl_errno($ch)) {
      return false;
    }
    $eml = (object) json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $output), true);
    curl_close($ch);
    return $eml;
  }

  /**
   *  Call API Get Record By Ref
   * 
   *  @return 200 {...}
   *  @return 400 {"error":true,"message":"not found id"}
   *  @return 400 {"error":true,"message":"Authorization Required"}
   * 
   */
  public static function recodeByRef($tr_id)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, env("URL_TSM") . env('query_tsm_url_transferrecords') . "?id=" . $tr_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    apiErpRepository::returnHeader($ch);
    $output = curl_exec($ch);

    if ($errno = curl_errno($ch)) {
      return false;
    }

    $tsm_op_transfer_records = (object) json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $output), true);
    if (isset($tsm_op_transfer_records->error)) {
      return false;
    }
    return $tsm_op_transfer_records;
  }
}
