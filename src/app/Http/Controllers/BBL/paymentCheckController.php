<?php

namespace App\Http\Controllers\BBL;

use App\Helpers\DateTimeManager;
use App\Helpers\MailManager;
use App\Http\Controllers\Controller;
use App\Models\BBL\logPayment;
use App\Models\BBL\transactionPayment;
use App\Repository\BBL\apiBBLRepository;
use App\Repository\BBL\configuationRepository;
use App\Repository\BBL\linkRepository;

class paymentCheckController extends Controller
{
  public $configuation;

  public function check()
  {
    $this->configuation = configuationRepository::getByBrand($_GET['brandIdentifier']);
    // mockController::mockDatafeed($_GET['Ref'], $this->configuation);
    return $this->exec();
  }

  public function exec()
  {
    $transaction = transactionPayment::where("order_code", $_GET['Ref'])
      ->where('dfsuccesscode', 0)
      ->orderBy('created_at', 'DESC')
      ->first();
    $log = logPayment::where("order_code", $_GET['Ref'])
      ->orderBy('date', 'DESC')
      ->first();
    $time = DateTimeManager::dateForApi();

   
    if (!$transaction) {
      $MerchantId = $transaction->dfMerchantId;
      $payRef = $transaction->dfpayRef;
      $amount = $transaction->amount;
      $order_code = $_GET['Ref'];
      $eci = $transaction->dfeci;
      $data = $this->basevalueFlight($MerchantId, $order_code, $payRef, $amount);

      
      $xml2 = apiBBLRepository::queryApi($data['url_bank'], $data['postfield_query']);

      if (!empty($xml2->record)) {
        $insert = [
          'product_detail' => $xml2->record[0]->remark,
          'order_code' => $xml2->record[0]->ref,
          'amount' => $xml2->record[0]->amt,
          'ttccname' => $xml2->record[0]->holder,
          'source_ip' => $xml2->record[0]->ipCountry,
          'dfsrc' => $xml2->record[0]->src,
          'dfprc' => $xml2->record[0]->prc,
          'dfOrd' => $xml2->record[0]->ord,
          'dfpayRef' => $xml2->record[0]->payRef,
          'dfAuthId' => $xml2->record[0]->authId,
          'dfpayerAuth' => $xml2->record[0]->payerAuth,
          'dfHolder' => $xml2->record[0]->holder,
          'dfsourceIp' => $xml2->record[0]->sourceIp,
          'dfipCountry' => $xml2->record[0]->ipCountry,
          'dfcc1316' => $xml2->record[0]->cc1316,
          'dfMerchantId' => $this->configuation['MerchantID'],
          'dfTxTime' => $xml2->record[0]->txTime,
          'data_source' => "Q"
        ];
        $currency = $xml2->record[0]->cur;
        if ($currency == '764') {
          $insert['currency'] = 'THB';
        } else {
          $insert['currency'] = 'USD';
        }
        $dfeci = $xml2->record[0]->eci;
        $insert['dfeci'] = $dfeci;
        if ($dfeci == '02') {
          $insert['ttcctype'] = 'M';
        } else if ($dfeci == '05') {
          $insert['ttcctype'] = 'V';
        } else {
          $insert['ttcctype'] = 'V';
        }
        if (($dfeci == '02' || $dfeci == '05' || $dfeci == '83') && $xml2->record[0]->src == '0' && $xml2->record[0]->src == '0') {
          $insert['dfsuccesscode'] = '0';
          transactionPayment::insert($insert);
        } else {
          $insert['dfsuccesscode'] = '1';
          transactionPayment::insert($insert);
        }
        transactionPayment::where('order_code', $order_code)
          ->where('dfeci', $insert['dfeci'])
          ->where('dfMerchantId', $insert['dfMerchantId'])
          ->where('dfpayRef', $insert['dfpayRef'])
          ->update([
            'brand_identifier' => $_GET['brandIdentifier']
          ]);
        $transaction = transactionPayment::where("order_code", $_GET['Ref'])
          ->orderBy('created_at', 'DESC')
          ->first();
      }
    } else {
      $transaction->brand_identifier = $_GET['brandIdentifier'];
      $transaction->save();
    }
    $MerchantId = $transaction->dfMerchantId;
    $payRef = $transaction->dfpayRef;
    $amount = $transaction->amount;
    $order_code = $_GET['Ref'];
    $eci = $transaction->dfeci;
    $data = $this->basevalueFlight($MerchantId, $order_code, $payRef, $amount);
    $fraud = $this->fraud($transaction, $log);

    if ($fraud) {

      transactionPayment::where('order_code', $order_code)
        ->where('dfeci', $eci)
        ->where('dfMerchantId', $MerchantId)
        ->where('dfpayRef', $payRef)
        ->update([
          'ttc_3Dcheck' => 'P'
        ]);
        logPayment::where('order_code', $order_code)
        ->update([
          'compare_status' => 'Match'
        ]);

      $result = apiBBLRepository::transactionSuccess($transaction, $order_code, $time);
      if(!isset($result['error'])) {
        $reqId = isset($result->requestId) ? $result->requestId : null ;
        $result = json_decode($result);

        transactionPayment::where('order_code', $order_code)
        ->where('dfeci', $eci)
        ->where('dfMerchantId', $MerchantId)
        ->where('dfpayRef', $payRef)
        ->update([
          'request_id' => $reqId
        ]); 
        try{
          // $data = apiBBLRepository::apiUpdateErpAfterSuccess($transaction, $order_code, $time);
        }catch(\Exception $e){

        }
      }

      return redirect()->to(linkRepository::decodeLink($log->successCallback));
    } else {

      $chkCancel = apiBBLRepository::cancel($data['url_bank'], $data['postfield_cancel']);
      if ($chkCancel) {
        transactionPayment::where('order_code', $order_code)
          ->where('dfeci', $eci)
          ->where('dfMerchantId', $MerchantId)
          ->where('dfpayRef', $payRef)
          ->update([
            'ttc_3Dcheck' => 'N'
          ]);
        logPayment::where('order_code', $order_code)
          ->update([
            'compare_status' => 'Not Match'
          ]);
        $xml = apiBBLRepository::queryApi($data['url_bank'], $data['postfield_query']);
        if (!empty($xml->record)) {
          $MailManager = MailManager::mailFail($xml, $order_code, $this->configuation);
        }

        
        $result = apiBBLRepository::transactionFail($transaction, $order_code, $time);
        if(!isset($result['error'])) {
          $result = json_decode($result);

          $reqId = isset($result->requestId) ? $result->requestId : null ;

          transactionPayment::where('order_code', $order_code)
          ->where('dfeci', $eci)
          ->where('dfMerchantId', $MerchantId)
          ->where('dfpayRef', $payRef)
          ->update([
            'request_id' => $reqId
          ]); 
        }
        return redirect()->to(linkRepository::decodeLink($log->failCallback));
      } else {
        $result = apiBBLRepository::transactionFail($transaction, $order_code, $time);
        if(!isset($result['error'])) {
          $result = json_decode($result);

          $reqId = isset($result->requestId) ? $result->requestId : null ;

          transactionPayment::where('order_code', $order_code)
          ->where('dfeci', $eci)
          ->where('dfMerchantId', $MerchantId)
          ->where('dfpayRef', $payRef)
          ->update([
            'request_id' => $reqId
          ]); 
        }
        return redirect()->to(linkRepository::decodeLink($log->failCallback));
      }
    }
  }

  public function fraud($transaction, $log)
  {
    if (!empty($log) && !empty($transaction)) {

      $chk_amount = $log->amount;
      $chk_holder = $log->card_holder;
      $chk_no = $log->card_no_rear;

      $log_amount = $transaction->amount;
      $log_holder = $transaction->dfHolder;
      $log_no = $transaction->dfcc1316;
      $eci = $transaction->dfeci;

      $holder_chk = array_filter(explode(' ', strtoupper($chk_holder)));
      if (!empty($holder_chk)) {
        $holder_chk = array_merge($holder_chk);
      }
      $holder_log = array_filter(explode(' ', strtoupper($log_holder)));
      if (!empty($holder_log)) {
        $holder_log = array_merge($holder_log);
      }
      if (!empty($holder_log) && !empty($holder_chk)) {
        $result_holder_log = array_diff_assoc($holder_log, $holder_chk);
        $result_holder_chk = array_diff_assoc($holder_chk, $holder_log);
      }

      if ($chk_amount == $log_amount && $log_no == $chk_no && !empty($chk_holder) && !empty($log_holder) && empty($result_holder_log) && empty($result_holder_chk) && ($eci == '02' || $eci == '05' || $eci == '83')) {

        return true;
      } else {
        return false;
      }
    }

    return false;
  }

  public function basevalueFlight($MerchantId, $order_code, $payRef, $amount)
  {
    $loginId = $this->configuation['public_key'];
    $password = $this->configuation['secret_key'];
    $url_bank = $this->configuation['orderApi'];
    $postfield_cancel = 'merchantId=' . $MerchantId . '&loginId=' . $loginId . '&password=' . $password . '&actionType=ReversalAuth&payRef=' . $payRef;
    $postfield_cap = 'merchantId=' . $MerchantId . '&loginId=' . $loginId . '&password=' . $password . '&actionType=Capture&payRef=' . $payRef . '&amount=' . $amount;
    $postfield_query = 'merchantId=' . $MerchantId . '&loginId=' . $loginId . '&password=' . $password . '&actionType=Query&orderRef=' . $order_code . '&payRef=' . $payRef;
    return [
      'url_bank' => $url_bank,
      'postfield_cancel' => $postfield_cancel,
      'postfield_query' => $postfield_query,
      'postfield_cap' => $postfield_cap,
    ];
  }
}
