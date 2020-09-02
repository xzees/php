<?php

namespace App\Http\Controllers\BBL;

use App\Helpers\AuthorizationManager;
use App\Helpers\HttpManager;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repository\BBL\logPaymentRepository;
use App\Repository\BBL\apiBBLRepository;
use App\Repository\BBL\configuationRepository;
use App\Repository\BBL\linkRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class formPaymentControlller extends Controller
{
  /**
   * @param $request {
   *    'orderRef' => 'required',
   *    'successCallback' => 'required',
   *    'failCallback' => 'required',
   *    'cardNo' => 'required',
   *    'epMonth' => 'required',
   *    'epYear' => 'required',
   *    'securityCode' => 'required',
   *    'cardHolder' => 'required',
   *    'brandIdentifier' => 'required',
   *    'productIdentifier' => 'required',
   *    'ref1' => 'required',
   *    'ref2' => 'required',
   *    'tr_currency'=>'THB'
   * }
   * 
   * @return status 200 text/html
   * @return status 500 redirect to page 500
   */
  public function formSubmit(Request $request)
  {
    try {
      /**
       * validate
       */
      $v = Validator::make($request->all(), [
        'orderRef' => 'required',
        'successCallback' => 'required',
        'failCallback' => 'required',
        'cardNo' => 'required',
        'epMonth' => 'required',
        'epYear' => 'required',
        'securityCode' => 'required',
        'cardHolder' =>  'required|regex:/^[a-zA-Z.\s]+$/',
        'brandIdentifier' => 'required',
        'productIdentifier' => 'required'
      ]);

      if ($v->fails()) {
        return response()->json(['error' => 'Param not find', "message" => $v->errors()->all()], 400);
      }
      $configuation = configuationRepository::getByBrand($request->brandIdentifier);

      $this->data_request = $request;
      $this->data_request->payment_type = "credit";
      $this->data_request->configuation = $configuation;
      $this->data_request->dfHolder = $request->cardHolder;

      $real_amount = logPaymentRepository::getAmountByApi(
        $this->data_request->orderRef,
        $this->data_request->productIdentifier,
        $this->data_request->brandIdentifier,
        "credit"
      );
      $this->data_request->amount = $real_amount[logPaymentRepository::AMOUNT];
      $this->data_request->request_id = $real_amount[logPaymentRepository::REQUEST_ID];
      $this->data_request->remark = $this->data_request->productIdentifier;
      logPaymentRepository::insertLogPayment($this->data_request);
      return apiBBLRepository::apiForm($this->data_request);
    } catch (\Exception $e) {
      // return redirect()->to(linkRepository::decodeLink($this->data_request->failCallback));
      dd($e->getMessage());
    }
  }

  /**
   * 
   * token for post form
   *
   * @return [{
   *  "element": "input",
   *  "name": "_token",
   *  "value": "JpF2nE3lcQhfMshcfr2CZ1YiEisseO2fEejRB5Op"
   * }]
   */
  public function token(Request $request) {

    AuthorizationManager::bearerToken($request);

    $data = [[
      "element"=> "input",
      "name"=> "_token",
      "value"=> csrf_token()
    ]];
    return response()->json($data,200);
  }

  public function test()
  {
    $data = [
      'merchantId' => '9683',
      'amount' => '100',
      'Ref' => 'asd',
      'currCode' => '764',
      'successUrl' => 'a.php',
      'failUrl' => 'a.php',
      'cancelUrl' => 'a.php',
      'payType' => "H",
      'lang' => "E",
      'remark' => '-',
      'pMethod' => 'VISA',
      'cardNo' => '4546289950108110',
      'epMonth' => '12',
      'epYear' => '2032',
      'cardHolder' => 'test',
      'securityCode' => '111'

    ];
    // $data['secureHash'] = hash("sha512", '9683'.'|'.$data['orderRef'].'|'.$data['currCode'].'|'.$data['amount'].'|'.$data['payType'].'|'.'JOcysDKQaWrvxnEDDPsTVu5Pyaf8BGqK'); 
    ?>

      <html>

      <head>
        <script type="text/javascript">
          function closethisasap() {
            document.forms["redirectpost"].submit();
          }
        </script>
      </head>

      <body >
        <form name="redirectpost" method="post" action="https://dev-bbl-datafeed.ttcglobal.network/payment/gateway/bbl/datafeed">
          <?php
          if (!is_null($data)) {
            foreach ($data as $k => $v) {
              echo '<input  name="' . $k . '" value="' . $v . '"> ';
            }
          }
          ?>
          <input type="submit" value="save" />
        </form>
      </body>

      </html>
      <?php
      exit();
  }

  public function tt()
  {
    dd($_SERVER);
  }
  
}
