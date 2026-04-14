<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantActive
{
    /**
     * Ensure the current tenant has an active subscription or valid trial.
     * This middleware should run AFTER ResolveTenant.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = app()->bound('current_tenant') ? app('current_tenant') : null;

        if (!$tenant) {
            // No tenant context — allow through (super admin routes)
            return $next($request);
        }

        if (!$tenant->isActive()) {
            // If the user is a tenant owner, let them access billing pages to reactivate
            if (auth()->check() && auth()->user()->role === 'tenant_owner') {
                $allowedRoutes = [
                    'tenant.billing',
                    'tenant.subscription',
                    'tenant.dashboard',
                    'logout',
                ];

                $currentRoute = $request->route()?->getName();

                if ($currentRoute && in_array($currentRoute, $allowedRoutes)) {
                    return $next($request);
                }
            }

            abort(403, 'This workspace subscription has expired. Please contact the workspace administrator.');
        }

        return $next($request);
    }
}
