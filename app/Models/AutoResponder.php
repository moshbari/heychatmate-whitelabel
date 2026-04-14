<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutoResponder extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $fillable = [
    'user_id', 'getresponse_status', 'getresponse_campaign_id', 'getresponse_token', 'sendlane_status', 'sendlane_apiKey', 'sendlane_apiHash', 'sendlane_listid', 'systemio_status', 'systemio_apikey'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
