<?php

namespace App\Repository\BBL;

use App\Models\BBL\configTemplete;

class configTempleteRepository
{
  /**
   * @param $order { product_detail:"",brand_identifier:"" } 
   * @param $payment_type example credit
   */
  public static function getConfig($order)
  {
    $data = configTemplete::where("product_identifier", $order->product_detail)
      ->where("brand_identifier", $order->brand_identifier)
      ->first();
    if (!$data) {
      echo 'Not found config in database';
      die();
    }
    return $data;
  }
}
