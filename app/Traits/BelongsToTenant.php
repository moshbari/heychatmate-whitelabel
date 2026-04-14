<?php

namespace App\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait BelongsToTenant
 *
 * Apply this trait to any model that should be scoped to a tenant.
 * It automatically:
 * - Adds a global scope to filter queries by the current tenant
 * - Sets tenant_id on new records
 * - Provides a tenant() relationship
 */
trait BelongsToTenant
{
    /**
     * Boot the trait.
     */
    protected static function bootBelongsToTenant(): void
    {
        // Auto-scope all queries to the current tenant
        static::addGlobalScope('tenant', function (Builder $builder) {
            $tenant = app()->bound('current_tenant') ? app('current_tenant') : null;

            if ($tenant) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', $tenant->id);
            }
        });

        // Auto-set tenant_id when creating new records
        static::creating(function ($model) {
            $tenant = app()->bound('current_tenant') ? app('current_tenant') : null;

            if ($tenant && empty($model->tenant_id)) {
                $model->tenant_id = $tenant->id;
            }
        });
    }

    /**
     * Get the tenant that owns this record.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    /**
     * Scope a query to a specific tenant (bypasses global scope).
     */
    public function scopeForTenant(Builder $query, int $tenantId): Builder
    {
        return $query->withoutGlobalScope('tenant')->where('tenant_id', $tenantId);
    }

    /**
     * Scope a query to include all tenants (bypasses global scope).
     * Useful for super admin views.
     */
    public function scopeAllTenants(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }
}
