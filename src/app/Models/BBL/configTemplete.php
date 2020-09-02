<?php

namespace App\Models\BBL;

use Illuminate\Database\Eloquent\Model;

class configTemplete extends Model
{
  protected $connection = 'DB_HOST_GB';
  protected $table = 'product_api_templete';
  public $timestamps = true;

  /**
   *  On = 1 off = 0 test amount 1.00
   */
  public static function test()
  {
    return 0;
  }
}
