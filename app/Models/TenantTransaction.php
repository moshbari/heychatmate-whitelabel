<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'trx_id',
        'tenant_id',
        'amount',
        'credits',
        'type',
        'remark',
        'details',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'boolean',
    ];

    // ── Relationships ──

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // ── Scopes ──

    public function scopeCredits($query)
    {
        return $query->where('type', '+');
    }

    public function scopeDebits($query)
    {
        return $query->where('type', '-');
    }
}
