<?php

namespace App\Http\Controllers\BBL;

use App\Helpers\DateTimeManager;
use App\Http\Controllers\Controller;
use App\Models\BBL\logPayment;
use App\Models\BBL\transactionPayment;
use App\Repository\BBL\apiBBLRepository;
use App\Repository\BBL\apiErpRepository;
use App\Repository\BBL\configuationRepository;
use App\Repository\BBL\linkRepository;

class paymentFailController extends Controller
{

  public function fail()
  {
    $configuation = configuationRepository::getByBrand($_GET['brandIdentifier']);

   
    transactionPayment::where('order_code', $_GET['Ref'])
    ->update([
      'brand_identifier' => $_GET['brandIdentifier']
    ]);
    $transaction = transactionPayment::where("order_code", $_GET['Ref'])
    ->orderBy('created_at', 'DESC')
    ->first();
    $log = logPayment::where("order_code", $_GET['Ref'])
      ->orderBy('date', 'DESC')
      ->first();
    $time = DateTimeManager::dateForApi();
    try{
      
      $result = apiBBLRepository::transactionFail($transaction, $_GET['Ref'], $time);
      if(!isset($result['error'])) {
        $result = json_decode($result);
        $reqId = isset($result->requestId) ? $result->requestId : null ;

        transactionPayment::where('order_code', $_GET['Ref'])
        ->update([
          'request_id' => $reqId
        ]); 
      }
    }catch(\Exception $e){
    }
    return redirect()->to(linkRepository::decodeLink($log->failCallback));
  }
}
