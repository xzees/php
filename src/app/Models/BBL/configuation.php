<?php

namespace App\Models\BBL;

use Illuminate\Database\Eloquent\Model;


class configuation extends Model
{
  protected $connection = 'DB_HOST_GB';
  protected $table = 'configuation';
  protected $primaryKey = 'id';
  public $timestamps = true;
}
