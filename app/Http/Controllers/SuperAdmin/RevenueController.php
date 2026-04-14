<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TenantSubscription;
use App\Models\TenantTransaction;

class RevenueController extends Controller
{
    public function subscriptions()
    {
        $subscriptions = TenantSubscription::with(['tenant', 'plan'])
            ->latest()
            ->paginate(20);

        return view('superadmin.revenue.subscriptions', compact('subscriptions'));
    }

    public function transactions()
    {
        $transactions = TenantTransaction::with('tenant')
            ->latest()
            ->paginate(20);

        return view('superadmin.revenue.transactions', compact('transactions'));
    }
}
