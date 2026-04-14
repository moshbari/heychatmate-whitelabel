<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::with(['owner', 'plan']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('custom_domain', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tenants = $query->latest()->paginate(20);
        $plans = TenantPlan::active()->get();

        return view('superadmin.tenants.index', compact('tenants', 'plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'owner_email' => 'required|email',
            'owner_name' => 'required|string|max:255',
            'slug' => 'required|string|max:100|unique:tenants,slug|alpha_dash',
            'plan_id' => 'nullable|exists:tenant_plans,id',
            'status' => 'required|in:active,trial,suspended',
        ]);

        // Create or find the owner user
        $owner = User::where('email', $request->owner_email)->first();

        if (!$owner) {
            $owner = User::create([
                'name' => $request->owner_name,
                'email' => $request->owner_email,
                'password' => bcrypt($request->password ?? Str::random(12)),
                'role' => 'tenant_owner',
                'type' => 'user',
                'status' => 1,
                'email_verified' => 1,
            ]);
        } else {
            $owner->update(['role' => 'tenant_owner']);
        }

        $plan = $request->plan_id ? TenantPlan::find($request->plan_id) : null;

        $tenant = Tenant::create([
            'owner_id' => $owner->id,
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'app_name' => $request->name,
            'plan_id' => $request->plan_id,
            'max_users' => $plan ? $plan->max_users : 5,
            'max_bots_per_user' => $plan ? $plan->max_bots_per_user : 3,
            'status' => $request->status,
            'trial_ends_at' => $request->status === 'trial' ? now()->addDays(14) : null,
        ]);

        // Link owner to tenant
        $owner->update(['tenant_id' => $tenant->id]);

        return redirect()->route('superadmin.tenants')->with('success', 'Tenant created successfully.');
    }

    public function show($id)
    {
        $tenant = Tenant::with(['owner', 'plan', 'users', 'transactions' => function ($q) {
            $q->latest()->take(20);
        }])->findOrFail($id);

        $plans = TenantPlan::active()->get();

        return view('superadmin.tenants.show', compact('tenant', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,suspended,trial,cancelled',
            'plan_id' => 'nullable|exists:tenant_plans,id',
            'max_users' => 'required|integer|min:1',
            'max_bots_per_user' => 'required|integer|min:1',
            'credit_balance' => 'nullable|numeric|min:0',
        ]);

        $tenant->update($request->only([
            'name', 'status', 'plan_id', 'max_users', 'max_bots_per_user',
        ]));

        if ($request->has('credit_balance') && $request->credit_balance != $tenant->credit_balance) {
            $diff = $request->credit_balance - $tenant->getOriginal('credit_balance');
            if ($diff > 0) {
                $tenant->addCredits($diff, 'admin_adjustment', 'Credits added by super admin');
            }
        }

        return redirect()->back()->with('success', 'Tenant updated successfully.');
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->update(['status' => 'cancelled']);

        return redirect()->route('superadmin.tenants')->with('success', 'Tenant has been cancelled.');
    }
}
