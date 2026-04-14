<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiSettingsController extends Controller
{
    public function index()
    {
        $tenant = current_tenant();
        return view('tenant.settings.api', compact('tenant'));
    }

    public function update(Request $request)
    {
        $tenant = current_tenant();

        $request->validate([
            'api_mode' => 'required|in:platform,own',
            'openai_api_key' => 'nullable|string|max:255',
            'ai_model' => 'nullable|string|max:100',
        ]);

        $tenant->api_mode = $request->api_mode;

        if ($request->api_mode === 'own') {
            if ($request->openai_api_key) {
                $tenant->openai_api_key = encrypt($request->openai_api_key);
            }
            if ($request->ai_model) {
                $tenant->ai_model = $request->ai_model;
            }
        }

        $tenant->save();

        return redirect()->back()->with('success', 'API settings updated successfully.');
    }
}
