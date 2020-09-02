<?php

namespace App\Http\Controllers\BBL;

use App\Helpers\HttpManager;
use App\Http\Controllers\Controller;
use App\Models\BBL\transactionPayment;
use App\Repository\BBL\apiErpRepository;

class mockController extends Controller
{
  public function formTest()
  {
    return view('test.form');
  }
  public function formTest2()
  {
    return view('test.form2');
  }

  public static function mockDatafeed($order_code, $config)
  {
    $data = apiErpRepository::cclog($order_code);

    $first = transactionPayment::where("log_id", $data->log_id)->first();
    if (!$first) {
      $param = [
        'Ref' => $data->order_code,
        'successcode' => $data->dfsuccesscode,
        'PayRef' => $data->dfpayRef,
        'Ord' => $data->dfOrd,
        'eci' => $data->dfeci,
        'AuthId' => $data->dfAuthId,
        'payerAuth' => $data->dfpayerAuth,
        'MerchantId' => $data->dfMerchantId,
        'TxTime' => $data->dfTxTime,
        'src' => $data->dfsrc,
        'prc' => $data->dfprc,
        'Holder' => $data->dfHolder,
        'sourceIp' => $data->dfsourceIp,
        'ipCountry' => $data->dfipCountry,
        'cc1316' => $data->dfcc1316,
        'remark' => $data->remark ?? $data->product_detail,
        'Amt' => $data->amount
      ];

      $curl_option_array = [
        CURLOPT_URL => $config['BASEURL'] . env('config_route') . '/datafeed',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query(
          $param
        ),
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_RETURNTRANSFER => true,
      ];
      $data = HttpManager::curl($curl_option_array);
    }
  }
}
