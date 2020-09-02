<?php

namespace App\Http\Controllers\BBL;

use App\Helpers\HttpManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Repository\BBL\apiBBLRepository;
use App\Repository\BBL\configTempleteRepository;
use App\Repository\BBL\configuationRepository;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Validator;

class templeteFormController extends Controller
{
  public function index(HttpRequest $request)
  {
    // vaildate
    $v = Validator::make($request->all(), [
      'orderRef' => 'required',
      'successCallback' => 'required',
      'failCallback' => 'required',
      'brandIdentifier' => 'required',
      'productIdentifier' => 'required'
    ]);

    if ($v->fails()) {
      return response()->json(['error' => 'Param not find', "message" => $v->errors()->all()], 400);
    }

    $configuation = configTempleteRepository::getConfig((object) [
      "product_detail" => $request->productIdentifier,
      "brand_identifier" => $request->brandIdentifier
    ]);

    // api to get templete
    $curl_option_array = [
      CURLOPT_URL => $configuation->api_standard,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_POST => 1,
      CURLOPT_HTTPHEADER => array(
        'API_KEY: ' . $configuation->api_key
      )
    ];
    $html = HttpManager::curl($curl_option_array, 'api update success');

    // input 
    $array_input = [
      'orderRef',
      'successCallback',
      'failCallback',
      'cardNo',
      'epMonth',
      'epYear',
      'securityCode',
      'cardHolder',
      'brandIdentifier',
      'productIdentifier',
    ];

    //create templete 
    $dochtml = new \domDocument('1.0', 'UTF-8');
    @$dochtml->loadHTML('' . $html);
    $form = view("template.index")->with('data', [
      'base_color' => $request->base_color ?? '#651d74',
      'termcondition_link' => $request->termcondition ?? 'https://www.thaitravelcenter.com/termcondition/'
    ]);
    $template = $dochtml->createDocumentFragment();
    $template->appendXML($form);


    $dochtml->getElementById("cde")->appendChild($template);
    echo $dochtml->saveHTML();
  }
}
