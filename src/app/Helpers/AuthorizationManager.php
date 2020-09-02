<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class AuthorizationManager
{
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
  
  public static function bearerToken($request)
  {
       $header = $request->header('Authorization');
       $data = '';
       if (Str::startsWith($header, 'Bearer ')) {
          $data = Str::substr($header, 7);
       }
      if ($data != env('ADMIN_API_KEY')) {
        echo json_encode([
          "success"=> 0,
          "status"=> 400,
          "message"=> "unauthorized",
        ]);
        exit;
      }
  }
}
