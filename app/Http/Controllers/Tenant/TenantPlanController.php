<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class TenantPlanController extends Controller
{
    public function index()
    {
        $tenant = current_tenant();
        $plans = Plan::where('tenant_id', $tenant->id)->get();

        return view('tenant.plans.index', compact('tenant', 'plans'));
    }

    public function store(Request $request)
    {
        $tenant = current_tenant();

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:month,year,credit',
            'credits' => 'required|integer|min:0',
            'max_bots' => 'required|integer|min:1',
        ]);

        Plan::create([
            'tenant_id' => $tenant->id,
            'name' => $request->name,
            'price' => $request->price,
            'type' => $request->type,
            'credits' => $request->credits,
            'max_bots' => $request->max_bots,
            'features' => $request->features,
            'subtitle' => $request->subtitle,
            'status' => 1,
        ]);

        return back()->with('success', 'Plan created successfully.');
    }

    public function update(Request $request, $id)
    {
        $tenant = current_tenant();
        $plan = Plan::where('tenant_id', $tenant->id)->findOrFail($id);

        $plan->update($request->only(['name', 'price', 'type', 'credits', 'max_bots', 'features', 'subtitle', 'status']));

        return back()->with('success', 'Plan updated successfully.');
    }

    public function destroy($id)
    {
        $tenant = current_tenant();
        $plan = Plan::where('tenant_id', $tenant->id)->findOrFail($id);
        $plan->update(['status' => 0]);

        return back()->with('success', 'Plan deactivated.');
    }
}
