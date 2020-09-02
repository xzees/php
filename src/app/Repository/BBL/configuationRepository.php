<?php

namespace App\Repository\BBL;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\HttpManager;
use App\Models\BBL\configuation;
use DB;

class configuationRepository extends Model
{
  /**
   * @param $brand is code example : TVG TTC
   */
  public static function getByBrand($brand)
  {
    return configuation::where("brand", strtoupper($brand))->get()->pluck('value', 'code');
  }
}
