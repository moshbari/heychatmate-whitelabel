<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantPlan;
use App\Models\TenantSubscription;
use App\Models\TenantTransaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalTenants' => Tenant::count(),
            'activeTenants' => Tenant::where('status', 'active')->count(),
            'trialTenants' => Tenant::where('status', 'trial')->count(),
            'totalUsers' => User::where('role', '!=', 'super_admin')->count(),
            'totalRevenue' => TenantTransaction::where('type', '+')->sum('amount'),
            'monthlyRevenue' => TenantTransaction::where('type', '+')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'recentTenants' => Tenant::with('owner')->latest()->take(5)->get(),
            'recentTransactions' => TenantTransaction::with('tenant')->latest()->take(10)->get(),
        ];

        return view('superadmin.dashboard', $data);
    }
}
