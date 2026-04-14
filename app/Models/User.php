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
    'role',
    'tenant_id',
    'invited_by',
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
    'last_login_at' => 'datetime',
  ];

  // ── Relationships ──

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

  // ── Tenant Relationships (NEW) ──

  /**
   * The tenant this user belongs to (null for super_admin).
   */
  public function tenantOrg()
  {
    return $this->belongsTo(Tenant::class, 'tenant_id');
  }

  /**
   * The tenant this user owns (for tenant_owner role).
   */
  public function ownedTenant()
  {
    return $this->hasOne(Tenant::class, 'owner_id');
  }

  /**
   * The user who invited this user.
   */
  public function invitedByUser()
  {
    return $this->belongsTo(User::class, 'invited_by');
  }

  // ── Role Helper Methods (NEW) ──

  public function isSuperAdmin(): bool
  {
    return $this->role === 'super_admin';
  }

  public function isTenantOwner(): bool
  {
    return $this->role === 'tenant_owner';
  }

  public function isTenantAdmin(): bool
  {
    return $this->role === 'tenant_admin';
  }

  public function isRegularUser(): bool
  {
    return $this->role === 'user';
  }

  public function isTenantLevel(): bool
  {
    return in_array($this->role, ['tenant_owner', 'tenant_admin']);
  }

  /**
   * Get the tenant for this user (resolves from relationship or owned).
   */
  public function getTenant(): ?Tenant
  {
    if ($this->tenant_id) {
      return $this->tenantOrg;
    }

    if ($this->isTenantOwner()) {
      return $this->ownedTenant;
    }

    return null;
  }
}
