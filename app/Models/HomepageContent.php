<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class HomepageContent extends Model
{
  use BelongsToTenant;

  public $timestamps = false;
}
