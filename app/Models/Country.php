<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
  use HasFactory;

  public $timestamps = false;
  // public function user()
  // {
  //   return $this->belongsTo(User::class, 'country');
  // }
}
