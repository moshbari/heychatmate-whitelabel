<?php

namespace App\Models;


use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserConfig extends Model
{
  use HasFactory, BelongsToTenant;

  public $timestamps = false;

  protected $fillable = [
    'tenant_id',
    'user_id',
    'api_key',
    'ai_model',
  ];
}
