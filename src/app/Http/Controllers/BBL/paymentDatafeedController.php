<?php

namespace App\Http\Controllers\BBL;

use App\Http\Controllers\Controller;
use App\Models\BBL\logPayment;
use App\Models\BBL\transactionPayment;
use App\Repository\BBL\apiErpRepository;
use App\Repository\BBL\configuationRepository;

class paymentDatafeedController extends Controller
{
  public function datafeed()
  {
    $log_id = transactionPayment::where("order_code", $_POST['Ref'])
      ->where("product_detail", "LIKE", '%Room%')
      ->orderBy("created_at", "DESC")
      ->first();
    $post = [
      'order_code' => $_POST['Ref'],
      'dfsuccesscode' => $_POST['successcode'],
      'dfpayRef' => $_POST['PayRef'],
      'dfOrd' => $_POST['Ord'],
      'dfeci' => $_POST['eci'],
      'dfAuthId' => $_POST['AuthId'],
      'dfpayerAuth' => $_POST['payerAuth'],
      'dfMerchantId' => $_POST['MerchantId'],
      'dfTxTime' => $_POST['TxTime'],
      'amount' => sprintf('%.2f', $_POST['Amt']),
      'dfsrc' => $_POST['src'],
      'dfprc' => $_POST['prc'],
      'dfHolder' => $_POST['Holder'],
      'dfsourceIp' => $_POST['sourceIp'],
      'dfipCountry' => $_POST['ipCountry'],
      'dfcc1316' => $_POST['cc1316'],
      'product_detail' => $_POST['remark'] ?? '-'
    ];
    if ($log_id) {
      transactionPayment::where('log_id', $log_id)
        ->where('order_code', $post['order_code'])
        ->where('amount', sprintf('%.2f', $_POST['Amt']))
        ->update($post);
      return true;
    } else {
      $data = (array) apiErpRepository::recodeByRef($_POST['Ref']);
      if(count($data) > 0 ){
        $post['currency'] = $data['tr_currency'] ?? "THB";
        $post['product_detail'] = $data['tr_product_detail'] ?? $_POST['remark'] ?? '-';
      }else{
        $post['currency'] = "THB";
        $post['product_detail'] = $_POST['remark'] ?? '-';
      }
      if ($post['dfeci'] == '02') {
        $post['ttcctype'] = 'M';
      } else if ($post['dfeci'] == '05') {
        $post['ttcctype'] = 'V';
      } else {
        $post['ttcctype'] = 'V';
      }
      transactionPayment::insert($post);
      return true;
    }

    return false;
  }
}
