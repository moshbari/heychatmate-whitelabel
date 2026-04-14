<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\TenantTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index()
    {
        $tenant = current_tenant();
        $transactions = TenantTransaction::where('tenant_id', $tenant->id)
            ->latest()
            ->paginate(20);

        return view('tenant.settings.credits', compact('tenant', 'transactions'));
    }

    /**
     * Distribute credits from tenant pool to a sub-user.
     */
    public function distribute(Request $request)
    {
        $tenant = current_tenant();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = User::where('tenant_id', $tenant->id)
            ->where('role', 'user')
            ->findOrFail($request->user_id);

        // Check tenant has enough credits (only if using platform API)
        if ($tenant->api_mode === 'platform') {
            if ($tenant->credit_balance < $request->amount) {
                return redirect()->back()->with('error', 'Insufficient credits in your pool. You have ' . $tenant->credit_balance . ' credits.');
            }

            // Deduct from tenant
            $tenant->deductCredits($request->amount, 'Distributed to user: ' . $user->name);
        }

        // Add to user
        $user->increment('credit_balance', $request->amount);

        // Record user transaction
        $trnx = new \App\Models\Transaction();
        $trnx->trx_id = str_rand();
        $trnx->user_id = $user->id;
        $trnx->tenant_id = $tenant->id;
        $trnx->amount = $request->amount;
        $trnx->remark = 'credit';
        $trnx->type = '+';
        $trnx->status = 1;
        $trnx->details = 'Credits distributed by ' . $tenant->app_name;
        $trnx->save();

        return redirect()->back()->with('success', $request->amount . ' credits distributed to ' . $user->name);
    }
}
