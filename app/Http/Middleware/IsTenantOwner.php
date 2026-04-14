<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsTenantOwner
{
    /**
     * Ensure the authenticated user is a tenant owner or tenant admin.
     * Also verifies they belong to the currently resolved tenant.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Must be tenant_owner or tenant_admin role
        if (!in_array($user->role, ['tenant_owner', 'tenant_admin'])) {
            abort(403, 'Access denied. Tenant owner privileges required.');
        }

        $tenant = app()->bound('current_tenant') ? app('current_tenant') : null;

        // If no tenant resolved from domain, resolve from user's tenant_id
        // This handles the case where tenant owner accesses /tenant/* routes
        // from the main platform domain
        if (!$tenant && $user->tenant_id) {
            $tenant = \App\Models\Tenant::find($user->tenant_id);

            if ($tenant) {
                app()->instance('current_tenant', $tenant);
                view()->share('currentTenant', $tenant);
                config(['app.name' => $tenant->app_name]);
            }
        }

        // Must have a valid tenant at this point
        if (!$tenant) {
            abort(403, 'No workspace associated with your account.');
        }

        // User must belong to the resolved tenant
        if ($user->tenant_id !== $tenant->id) {
            abort(403, 'Access denied. You do not belong to this workspace.');
        }

        return $next($request);
    }
}
