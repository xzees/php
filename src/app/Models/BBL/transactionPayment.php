<?php

namespace App\Models\BBL;

use Illuminate\Database\Eloquent\Model;

class transactionPayment extends Model
{
  protected $connection = 'DB_HOST_GB';
  protected $table = 'payment_transaction';
  protected $primaryKey = 'log_id';
  public $timestamps = true;
}
