<?php

namespace App\Helpers;


class EncodeManager
{

  // public static function decrypt($encrypted_id, $key)
  // {
  //   $data = @pack('H*', $encrypted_id);
  //   $data = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $data, 'ecb');
  //   $data = base_convert($data, 36, 10);
  //   return $data;
  // }

  // public static function encrypt($id, $key)
  // {
  //   $id = base_convert($id, 10, 36);
  //   $data = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $id, 'ecb');
  //   $data = bin2hex($data);
  //   return $data;
  // }

  public static function encrypt($data,  $key,  $method = 'AES-128-CBC')
  {
    $ivSize = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivSize);

    $encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);

    // For storage/transmission, we simply concatenate the IV and cipher text
    $encrypted = base64_encode($iv . $encrypted);
    $encrypted = str_replace("/", "|", $encrypted);
    return $encrypted;
  }

  public static function decrypt($data,  $key,  $method = 'AES-128-CBC')
  {
    $data = str_replace("|", "/", $data);
    $data = base64_decode($data);
    $ivSize = openssl_cipher_iv_length($method);
    $iv = substr($data, 0, $ivSize);
    $data = openssl_decrypt(substr($data, $ivSize), $method, $key, OPENSSL_RAW_DATA, $iv);

    return $data;
  }
}
