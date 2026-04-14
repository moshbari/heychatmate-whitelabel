<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'billing_cycle',
        'max_users',
        'max_bots_per_user',
        'credits_included',
        'custom_domain_allowed',
        'own_api_key_allowed',
        'white_label_full',
        'features',
        'subtitle',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'custom_domain_allowed' => 'boolean',
        'own_api_key_allowed' => 'boolean',
        'white_label_full' => 'boolean',
        'features' => 'array',
        'status' => 'boolean',
    ];

    // ── Relationships ──

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'plan_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(TenantSubscription::class, 'tenant_plan_id');
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
