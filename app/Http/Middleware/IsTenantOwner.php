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
        $tenant = app()->bound('current_tenant') ? app('current_tenant') : null;

        // Must be tenant_owner or tenant_admin role
        if (!in_array($user->role, ['tenant_owner', 'tenant_admin'])) {
            abort(403, 'Access denied. Tenant owner privileges required.');
        }

        // If there's a resolved tenant, user must belong to it
        if ($tenant && $user->tenant_id !== $tenant->id) {
            abort(403, 'Access denied. You do not belong to this workspace.');
        }

        return $next($request);
    }
}
