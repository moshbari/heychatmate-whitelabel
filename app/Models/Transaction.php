<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  use HasFactory, BelongsToTenant;

  /**
   * Transaction belongs to a single user
   *
   *
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
