<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'tenant_plan_id',
        'amount',
        'cycle',
        'due_date',
        'payment_method',
        'stripe_subscription_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'datetime',
    ];

    // ── Relationships ──

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function plan()
    {
        return $this->belongsTo(TenantPlan::class, 'tenant_plan_id');
    }

    // ── Helper Methods ──

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->due_date && $this->due_date->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->due_date && $this->due_date->isPast();
    }
}
