<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
  use HasFactory;

  /**
   * Subscription belongs to a single user
   *
   *
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }


  /**
   * Plan belongs to a single user
   *
   *
   */
  public function plan()
  {
    return $this->belongsTo(Plan::class);
  }
  public function gateway()
  {
    return $this->belongsTo(PaymentGateway::class);
  }
}
