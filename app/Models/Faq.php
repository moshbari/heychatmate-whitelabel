<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
  use BelongsToTenant;

  public $timestamps = false;
}
