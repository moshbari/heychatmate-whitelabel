<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatAssistant;
use App\Models\Transaction;
use App\Models\User;

class TenantDashboardController extends Controller
{
    public function index()
    {
        $tenant = current_tenant();

        $data = [
            'tenant' => $tenant,
            'totalUsers' => User::where('tenant_id', $tenant->id)->where('role', 'user')->count(),
            'maxUsers' => $tenant->max_users,
            'totalBots' => ChatAssistant::where('tenant_id', $tenant->id)->count(),
            'totalChats' => Chat::where('tenant_id', $tenant->id)->count(),
            'todayChats' => Chat::where('tenant_id', $tenant->id)->whereDate('created_at', today())->count(),
            'creditBalance' => $tenant->credit_balance,
            'apiMode' => $tenant->api_mode,
            'recentUsers' => User::where('tenant_id', $tenant->id)
                ->where('role', 'user')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('tenant.dashboard', $data);
    }

    public function analytics()
    {
        $tenant = current_tenant();

        $data = [
            'tenant' => $tenant,
            'totalUsers' => User::where('tenant_id', $tenant->id)->where('role', 'user')->count(),
            'totalBots' => ChatAssistant::where('tenant_id', $tenant->id)->count(),
            'totalChats' => Chat::where('tenant_id', $tenant->id)->count(),
            'todayChats' => Chat::where('tenant_id', $tenant->id)->whereDate('created_at', today())->count(),
            'monthlyChats' => Chat::where('tenant_id', $tenant->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'creditBalance' => $tenant->credit_balance,
            'totalCreditsUsed' => Transaction::where('tenant_id', $tenant->id)
                ->where('type', '-')
                ->sum('credits'),
        ];

        return view('tenant.analytics', $data);
    }
}
