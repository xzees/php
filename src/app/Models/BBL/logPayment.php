<?php

namespace App\Models\BBL;

use Illuminate\Database\Eloquent\Model;


class logPayment extends Model
{
  protected $connection = 'DB_HOST_GB';
  protected $table = 'payment_log';
  protected $primaryKey = 'id';
  public $timestamps = false;
}
