<?php

namespace App\Repository\BBL;

use App\Helpers\ImageManager;
use Illuminate\Database\Eloquent\Model;
use App\Models\BBL\transactionPayment;
use DB;
use App\Helpers\MailManager;
use App\Http\Controllers\BBL\linkFullPaymentController;
use App\Repository\BBL\apiErpRepository;

class transactionPaymentRepository extends Model
{
  public static function logicCreditCard($data)
  {
    if ($data != "") {
      $data = substr($data, 0, 4) . "xxxxxxxx" . substr($data, 12, 4);
      return $data;
    }
    return "";
  }

  public function typeCard($cardNo, $returnType = "s")
  {
    if (substr($cardNo, 0, 1) == 4) {
      return $returnType == "s" ? 'V' : 'VISA';
    } else if (substr($cardNo, 0, 1) == 5) {
      return $returnType == "s" ? 'M' : 'MASTER';
    } else {
      return "";
    }
  }
}
