<?php

namespace App\Repository\BBL;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\HttpManager;
use App\Models\BBL\logPayment;
use App\Repository\BBL\configApiRepository;
use DB;

class logPaymentRepository extends Model
{

  const AMOUNT = 'amount';
  const REQUEST_ID = 'request_id';

  public static function getAmountByApi($ref, $product_identifier, $brand_identifier, $payment_type)
  {
    $config = configApiRepository::getConfig(
      (object) array(
        'product_detail' => $product_identifier,
        'brand_identifier' => $brand_identifier
      ),
      $payment_type
    );

    $url = linkRepository::api_standard_retrieve_booking_url($config->api_standard_retrieve_booking_url,$ref);
    $curl_option_array = [
      CURLOPT_URL => $url,
      CURLOPT_HTTPHEADER => array(
        'API_KEY: ' . $config->api_key,
      ),
      CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0',
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_RETURNTRANSFER => true
    ];

    $server_output = HttpManager::curl($curl_option_array, "get api amount " . $payment_type);
    try {
      $data = json_decode($server_output);
      unset($server_output);
      $price_object_key = explode(".", $config->price_object_key);
      $value = $data;
      foreach ($price_object_key as $k => $v) {
        $value = $value->$v;
      }

      $reqId = isset($data->requestId) ? $data->requestId : null ;
      return [
        logPaymentRepository::AMOUNT=>$value,
        logPaymentRepository::REQUEST_ID=>$reqId
      ];
    } catch (\Exception $e) {
      return array(
        'error' => $e->getMessage()
      );
    }
  }


  public static function getContactByApi($ref, $product_identifier, $brand_identifier, $payment_type)
  {
    $config = configApiRepository::getConfig(
      (object) array(
        'product_detail' => $product_identifier,
        'brand_identifier' => $brand_identifier
      ),
      $payment_type
    );

    $url =linkRepository::api_standard_retrieve_booking_url($config->api_standard_retrieve_booking_url,$ref);

    $curl_option_array = [
      CURLOPT_URL => $url,
      CURLOPT_HTTPHEADER => array(
        'API_KEY: ' . $config->api_key
      ),
      CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0',
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_RETURNTRANSFER => true,
    ];

    $server_output = HttpManager::curl($curl_option_array, "get api amount " . $payment_type);

    try {
      $data = json_decode($server_output);

      return $data->data->reservation->contactInfo;
    } catch (\Exception $e) {
      return array(
        'error' => $e->getMessage()
      );
    }
  }


  public static function insertLogPayment($data_request)
  {
    // $chk = logPayment::where("order_code", $data_request->orderRef)->first();

    // if (!$chk) {
      $insert_data['order_code']      = $data_request->orderRef;
      $insert_data['amount']          = $data_request->amount ?? "0";
      $insert_data['ip_client']       = request()->ip();
      $insert_data['card_holder']     = $data_request->dfHolder;
      $insert_data['card_no_rear']    = isset($data_request->cardNo) ? substr($data_request->cardNo, 12, 4) : "";
      $insert_data['date']            = date('Y-m-d H:i:s');
      $insert_data['successCallback'] = $data_request->successCallback;
      $insert_data['failCallback'] = $data_request->failCallback;
      $insert_data['request_id'] = $data_request->request_id;

      logPayment::insert($insert_data);
    // }
  }

  public static function getOrder($order_code)
  {
    $order = logPayment::where("order_code", $order_code)
    ->where("created_at","desc")
      ->first();
    return $order;
  }
  public static function updateOrder($order_code, $param)
  {
    logPayment::where("order_code", $order_code)
      ->update($param);
  }
}
