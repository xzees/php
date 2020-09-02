<?php

namespace App\Repository\BBL;

use App\Models\BBL\configApi;

class configApiRepository
{
  /**
   * @param $order { product_detail:"",brand_identifier:"" } 
   * @param $payment_type example credit
   */
  public static function getConfig($order, $payment_type)
  {
    $data = configApi::where("product_identifier", $order->product_detail)
      ->where("brand_identifier", $order->brand_identifier)
      ->where("payment_type", $payment_type)
      ->first();
    if (!$data) {
      echo 'Not found config in database';
      die();
    }
    return $data;
  }
}
