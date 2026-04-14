<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenant
{
    /**
     * The platform's base domain for the white-label system.
     */
    private const PLATFORM_DOMAIN = 'whitelabel.heychatmate.com';

    /**
     * Handle an incoming request.
     *
     * Resolves the current tenant from the request's hostname:
     * 1. If it's the platform domain itself → no tenant (super admin area)
     * 2. If it's a subdomain of the platform → resolve by slug
     * 3. If it's a custom domain → resolve by verified custom_domain
     * 4. If no tenant found → 404
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // If this is the main platform domain, no tenant resolution needed
        // Super admin routes handle their own auth
        if ($host === self::PLATFORM_DOMAIN || $host === 'localhost' || $host === '127.0.0.1') {
            return $next($request);
        }

        // Try to resolve tenant from domain
        $tenant = Tenant::resolveFromDomain($host);

        if (!$tenant) {
            abort(404, 'This workspace does not exist.');
        }

        // Check if tenant is active
        if (!$tenant->isActive()) {
            abort(403, 'This workspace is currently inactive. Please contact the administrator.');
        }

        // Bind tenant to the service container so it's available everywhere
        app()->instance('current_tenant', $tenant);

        // Share tenant with all views
        view()->share('currentTenant', $tenant);

        // Set tenant-specific config
        config(['app.name' => $tenant->app_name]);

        return $next($request);
    }
}
