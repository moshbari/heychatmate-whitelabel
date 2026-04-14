<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TenantPlan;
use Illuminate\Http\Request;

class TenantPlanController extends Controller
{
    public function index()
    {
        $plans = TenantPlan::withCount('tenants')->get();
        return view('superadmin.tenant-plans.index', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly,one-time',
            'max_users' => 'required|integer|min:1',
            'max_bots_per_user' => 'required|integer|min:1',
            'credits_included' => 'required|integer|min:0',
            'custom_domain_allowed' => 'boolean',
            'own_api_key_allowed' => 'boolean',
            'white_label_full' => 'boolean',
        ]);

        TenantPlan::create([
            'name' => $request->name,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'max_users' => $request->max_users,
            'max_bots_per_user' => $request->max_bots_per_user,
            'credits_included' => $request->credits_included,
            'custom_domain_allowed' => $request->boolean('custom_domain_allowed'),
            'own_api_key_allowed' => $request->boolean('own_api_key_allowed'),
            'white_label_full' => $request->boolean('white_label_full'),
            'subtitle' => $request->subtitle,
            'status' => true,
        ]);

        return redirect()->back()->with('success', 'Plan created successfully.');
    }

    public function update(Request $request, $id)
    {
        $plan = TenantPlan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly,one-time',
            'max_users' => 'required|integer|min:1',
            'max_bots_per_user' => 'required|integer|min:1',
            'credits_included' => 'required|integer|min:0',
        ]);

        $plan->update($request->only([
            'name', 'price', 'billing_cycle', 'max_users', 'max_bots_per_user',
            'credits_included', 'subtitle',
        ]) + [
            'custom_domain_allowed' => $request->boolean('custom_domain_allowed'),
            'own_api_key_allowed' => $request->boolean('own_api_key_allowed'),
            'white_label_full' => $request->boolean('white_label_full'),
        ]);

        return redirect()->back()->with('success', 'Plan updated successfully.');
    }

    public function destroy($id)
    {
        $plan = TenantPlan::findOrFail($id);
        $plan->update(['status' => false]);

        return redirect()->back()->with('success', 'Plan deactivated.');
    }
}
