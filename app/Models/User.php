<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'type',
    'email_verified',
    'credit_balance',
    'subscription_id',
    'country',
    'phone',
    'status',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];



  public function subscription()
  {
    return $this->hasOne(UserSubscription::class);
  }


  public function countryData()
  {
    return $this->hasOne(Country::class, 'id');
  }

  public function hasActiveSubscription()
  {
    return optional($this->subscription)->isActive() ?? false;
  }
  public function assistant()
  {
    return $this->hasMany(ChatAssistant::class);
  }
  public function chats()
  {
    return $this->hasMany(Chat::class);
  }
  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function autoresp()
  {
    return $this->hasOne(AutoResponder::class, 'id');
  }

  public function socialProviders()
  {
    return $this->hasMany(SocialProvider::class);
  }

}
