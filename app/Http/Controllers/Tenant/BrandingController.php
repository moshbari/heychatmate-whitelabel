<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandingController extends Controller
{
    public function index()
    {
        $tenant = current_tenant();
        return view('tenant.branding.index', compact('tenant'));
    }

    public function update(Request $request)
    {
        $tenant = current_tenant();

        $request->validate([
            'app_name' => 'required|string|max:255',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'footer_text' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'favicon' => 'nullable|mimes:png,jpg,jpeg,ico|max:1024',
        ]);

        $tenant->app_name = $request->app_name;
        $tenant->primary_color = $request->primary_color ?? '#696cff';
        $tenant->secondary_color = $request->secondary_color;
        $tenant->footer_text = $request->footer_text;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = 'tenants/' . $tenant->id . '/branding';
            $filename = 'logo.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs($path, $filename, 'public');
            $tenant->logo = $filename;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $path = 'tenants/' . $tenant->id . '/branding';
            $filename = 'favicon.' . $request->file('favicon')->getClientOriginalExtension();
            $request->file('favicon')->storeAs($path, $filename, 'public');
            $tenant->favicon = $filename;
        }

        $tenant->save();

        return redirect()->back()->with('success', 'Branding updated successfully.');
    }
}
