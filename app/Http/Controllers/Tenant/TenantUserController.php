<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TenantUserController extends Controller
{
    public function index(Request $request)
    {
        $tenant = current_tenant();

        $query = User::where('tenant_id', $tenant->id)
            ->where('role', 'user');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->with('subscription.plan')->latest()->paginate(20);
        $canAddUser = $tenant->canAddUser();
        $userCount = User::where('tenant_id', $tenant->id)->where('role', 'user')->count();

        return view('tenant.users.index', compact('users', 'tenant', 'canAddUser', 'userCount'));
    }

    public function store(Request $request)
    {
        $tenant = current_tenant();

        if (!$tenant->canAddUser()) {
            return redirect()->back()->with('error', 'You have reached your maximum user limit. Please upgrade your plan.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
            'type' => 'user',
            'tenant_id' => $tenant->id,
            'invited_by' => auth()->id(),
            'status' => 1,
            'email_verified' => 1,
            'credit_balance' => $request->initial_credits ?? 0,
        ]);

        return redirect()->back()->with('success', 'User "' . $user->name . '" created successfully.');
    }

    public function show($id)
    {
        $tenant = current_tenant();
        $user = User::where('tenant_id', $tenant->id)
            ->where('role', 'user')
            ->with(['subscription.plan', 'assistant', 'transactions' => function ($q) {
                $q->latest()->take(20);
            }])
            ->findOrFail($id);

        return view('tenant.users.show', compact('user', 'tenant'));
    }

    public function update(Request $request, $id)
    {
        $tenant = current_tenant();
        $user = User::where('tenant_id', $tenant->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'status' => 'required|in:0,1',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        // Update credits if provided
        if ($request->has('credit_balance')) {
            $user->update(['credit_balance' => max(0, (float) $request->credit_balance)]);
        }

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function updatePassword(Request $request, $id)
    {
        $tenant = current_tenant();
        $user = User::where('tenant_id', $tenant->id)->findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update(['password' => bcrypt($request->password)]);

        return redirect()->back()->with('success', 'Password changed successfully for ' . $user->name);
    }

    public function destroy($id)
    {
        $tenant = current_tenant();
        $user = User::where('tenant_id', $tenant->id)
            ->where('role', 'user')
            ->findOrFail($id);

        $user->delete();

        return redirect()->route('tenant.users')->with('success', 'User deleted successfully.');
    }

    public function invite(Request $request)
    {
        $tenant = current_tenant();

        if (!$tenant->canAddUser()) {
            return redirect()->back()->with('error', 'You have reached your maximum user limit.');
        }

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
        ]);

        // Create user with temporary password
        $tempPassword = Str::random(10);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($tempPassword),
            'role' => 'user',
            'type' => 'user',
            'tenant_id' => $tenant->id,
            'invited_by' => auth()->id(),
            'status' => 1,
            'email_verified' => 1,
        ]);

        // Send invitation email
        try {
            email([
                'email' => $request->email,
                'name' => $request->name,
                'subject' => 'You have been invited to ' . $tenant->app_name,
                'message' => 'Hello ' . $request->name . ',<br><br>'
                    . 'You have been invited to join <strong>' . $tenant->app_name . '</strong>.<br><br>'
                    . 'Your login details:<br>'
                    . 'Email: ' . $request->email . '<br>'
                    . 'Password: ' . $tempPassword . '<br><br>'
                    . 'Login at: <a href="' . $tenant->url . '/login">' . $tenant->url . '/login</a><br><br>'
                    . 'Please change your password after logging in.',
            ]);
        } catch (\Exception $e) {
            // Email failed but user was created
        }

        return redirect()->back()->with('success', 'Invitation sent to ' . $request->email . '. Temporary password: ' . $tempPassword);
    }
}
