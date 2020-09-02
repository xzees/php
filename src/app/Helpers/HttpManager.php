<?php

namespace App\Helpers;


class HttpManager
{
  public static function curl($curl_option_array, $action = null)
  {
    $ch = curl_init();
    curl_setopt_array($ch, $curl_option_array);
    $server_output = curl_exec($ch);
    if (curl_errno($ch)) {
      $error = curl_error($ch);
      curl_close($ch);
      unset($ch, $curl_option_array);
      return array(
        'error' => 'Curl error: ' . $error
      );
    }
    curl_close($ch);
    unset($ch, $curl_option_array);
    return $server_output;
  }

  public static function getip()
  {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
      $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }
}
