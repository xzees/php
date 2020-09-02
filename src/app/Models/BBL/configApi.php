<?php

namespace App\Models\BBL;

use Illuminate\Database\Eloquent\Model;

class configApi extends Model
{
  protected $connection = 'DB_HOST_GB';
  protected $table = 'product_internal_detail';
  public $timestamps = true;

  /**
   *  On = 1 off = 0 test amount 1.00
   */
  public static function test()
  {
    return 0;
  }
}
