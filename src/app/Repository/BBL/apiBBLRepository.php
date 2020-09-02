<?php

namespace App\Repository\BBL;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\HttpManager;
use App\Repository\BBL\logPaymentRepository;
use DB;

class apiBBLRepository extends Model
{

  public static function apiForm($data_request)
  {

    $param = [
      'merchantId' => $data_request->configuation['MerchantID'],
      'amount' => $data_request->amount,
      'orderRef' => $data_request->orderRef,
      'currCode' => isset($data_request->tr_currency) && $data_request->tr_currency != "THB" ? '840' : '764',
      'successUrl' => linkRepository::genLinkFromSuccess($data_request),
      'failUrl' => linkRepository::genLinkFromFail($data_request),
      'cancelUrl' => linkRepository::genLinkFromFail($data_request),
      'payType' => "H",
      'lang' => "E",
      'remark' => $data_request->productIdentifier,
      'pMethod' => apiBBLRepository::typeCard($data_request->cardNo, "r"),
      'cardNo' => $data_request->cardNo,
      'epMonth' => $data_request->epMonth,
      'epYear' => $data_request->epYear,
      'cardHolder' => $data_request->dfHolder,
      'securityCode' => $data_request->securityCode,
    ];
    // Todo add in database secureHashSecret 
    $param['secureHash'] = hash("sha512", $param['merchantId'].'|'.$param['orderRef'].'|'.$param['currCode'].'|'.$param['amount'].'|'.$param['payType'].'|'.$data_request->configuation['secureHashSecret']); 
    return apiBBLRepository::redirect_post_by_api($data_request->configuation['payComp'], $param);
  }

  public static function redirect_post_by_api($url, array $data)
  {

    $curl_option_array = [
      CURLOPT_URL => $url,
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => http_build_query(
        $data
      ),
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER=> [
        "Content-type"=>"application/x-www-form-urlencoded",
        'Content-Length' => strlen(
          http_build_query(
            $data
          )
        )
      ]
    ];
    
    $result_data = HttpManager::curl($curl_option_array);
    
    if(isset($result_data['error']) || $result_data == "") {
      apiBBLRepository::redirect_post($url, $data);
    }else{
      return '<base href="'.$url.'" />'.$result_data;
    }
    
  }


  public static function redirect_post($url, array $data)
  {
?>
    <html>

    <head>
      <script type="text/javascript">
        function closethisasap() {
          document.forms["redirectpost"].submit();
        }
      </script>
    </head>

    <body onload="closethisasap();">
      <form name="redirectpost" method="post" action="<?= $url; ?>">
        <?php
        if (!is_null($data)) {
          foreach ($data as $k => $v) {
            echo '<input type="hidden" name="' . $k . '" value="' . $v . '"> ';
          }
        }
        ?>
      </form>
    </body>

    </html>
<?php
    exit;
  }

  public static function typeCard($cardNo, $returnType = "s")
  {
    if (substr($cardNo, 0, 1) == 4) {
      return $returnType == "s" ? 'V' : 'VISA';
    } else if (substr($cardNo, 0, 1) == 5) {
      return $returnType == "s" ? 'M' : 'Master';
    } else {
      return "";
    }
  }

  public static function queryApi($url_bank, $postfield_query)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_bank);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield_query);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result_data = curl_exec($ch);
    // Check for errors and display the error message
    if ($errno = curl_errno($ch)) {
      $error_message = curl_strerror($errno);
      dd("cURL error ({$errno}):\n {$error_message}");
    }
    curl_close($ch);

    $xml = simplexml_load_string($result_data);
    return $xml;
  }

  public static function cancel($url_bank, $postfield_cancel)
  {
    try {
      $curl_option_array = [
        CURLOPT_URL => $url_bank,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $postfield_cancel,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_HTTPHEADER => array("Content-type: application/x-www-form-urlencoded"),
        CURLOPT_RETURNTRANSFER => 1
      ];
      $result_data = HttpManager::curl($curl_option_array);
      parse_str($result_data, $result_data);
      $resultCode = $result_data['resultCode'];

      if ($resultCode == 0) {
        return true;
      } else {
        return false;
      }
    } catch (\Exception $e) {
      return false;
    }
    return false;
  }

  public static function apiUpdateErpAfterSuccess($transaction, $order_code, $time)
  {
    $config = configApiRepository::getConfig($transaction, "credit");

    $url = linkRepository::api_standard_retrieve_booking_url($config->api_standard_retrieve_booking_url,$order_code);
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

    $server_output = HttpManager::curl($curl_option_array);
    $server_output_decode = json_decode($server_output);
    $curl_option_array_erp = [
      CURLOPT_URL => $config->api_standard_update_erp_status_success_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => isset($server_output_decode->data) ? json_encode($server_output_decode->data) : '' ,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic ' . $config->api_key_erp,
        'Content-Type: application/json'
      )
    ];

    return HttpManager::curl($curl_option_array_erp, 'api update erp success');
  }

  public static function transactionSuccess($transaction, $order_code, $time)
  {
    $config = configApiRepository::getConfig($transaction, "credit");
    $curl_param =  http_build_query(
      [
        'channel' => 'cc',
        'creditCardLast4Digits' => $transaction->dfcc1316,
        'creditCardType' => $transaction->ttcctype == "V" ? "VISA" : ($transaction->ttcctype == "M" ? "MASTER" : ""),
        'orderRef' => $order_code,
        'timestamp' => $time
      ]
    );
    $curl_option_array = [
      CURLOPT_URL => $config->api_standard_update_payment_status_success_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => $curl_param,
      CURLOPT_HTTPHEADER => array(
        'API_KEY: ' . $config->api_key
      )
    ];

    return HttpManager::curl($curl_option_array, 'api update success');
  }

  public static function transactionFail($transaction, $order_code, $time)
  {
    $config = configApiRepository::getConfig($transaction, "credit");
    $curl_param =  http_build_query(
      [
        'channel' => 'cc',
        'creditCardLast4Digits' => $transaction->dfcc1316,
        'creditCardType' => $transaction->ttcctype == "V" ? "VISA" : ($transaction->ttcctype == "M" ? "MASTER" : ""),
        'orderRef' => $order_code,
        'timestamp' => $time
      ]
    );
    $curl_option_array = [
      CURLOPT_URL => $config->api_standard_update_payment_status_fail_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => $curl_param,
      CURLOPT_HTTPHEADER => array(
        'API_KEY: ' . $config->api_key
      )
    ];
    return HttpManager::curl($curl_option_array, 'api update success');
  }

  public static function apiGetTemplete($data_request)
  {

    $param = [
      'orderRef' => $data_request->orderRef,
    ];
    apiBBLRepository::redirect_post($data_request->configuation['payComp'], $param);
  }
}
