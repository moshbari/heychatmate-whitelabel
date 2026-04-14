<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $tenant = current_tenant();
        return view('tenant.settings.payment', compact('tenant'));
    }

    public function update(Request $request)
    {
        $tenant = current_tenant();

        $request->validate([
            'payment_processor' => 'required|in:stripe,jvzoo,whop',
        ]);

        $tenant->payment_processor = $request->payment_processor;

        switch ($request->payment_processor) {
            case 'stripe':
                $request->validate([
                    'stripe_key' => 'required|string',
                    'stripe_secret' => 'required|string',
                ]);
                $tenant->stripe_key = encrypt($request->stripe_key);
                $tenant->stripe_secret = encrypt($request->stripe_secret);
                if ($request->stripe_webhook_secret) {
                    $tenant->stripe_webhook_secret = encrypt($request->stripe_webhook_secret);
                }
                break;

            case 'jvzoo':
                $request->validate([
                    'jvzoo_secret_key' => 'required|string',
                ]);
                $tenant->jvzoo_secret_key = encrypt($request->jvzoo_secret_key);
                if ($request->jvzoo_api_key) {
                    $tenant->jvzoo_api_key = encrypt($request->jvzoo_api_key);
                }
                break;

            case 'whop':
                $request->validate([
                    'whop_api_key' => 'required|string',
                    'whop_company_id' => 'required|string',
                ]);
                $tenant->whop_api_key = encrypt($request->whop_api_key);
                $tenant->whop_company_id = $request->whop_company_id;
                if ($request->whop_webhook_secret) {
                    $tenant->whop_webhook_secret = encrypt($request->whop_webhook_secret);
                }
                break;
        }

        $tenant->save();

        return redirect()->back()->with('success', ucfirst($request->payment_processor) . ' payment settings updated successfully.');
    }
}
