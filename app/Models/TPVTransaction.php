<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TPVTransaction extends Model
{

  protected $table = 'tpv_transactions';
  protected $guarded = [];
  use HasFactory;
}
