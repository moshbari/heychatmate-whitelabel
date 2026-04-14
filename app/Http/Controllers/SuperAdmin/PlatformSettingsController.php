<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PlatformSettingsController extends Controller
{
    public function general()
    {
        $settings = Setting::whereNull('tenant_id')->pluck('value', 'key')->toArray();
        return view('superadmin.settings.general', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $keys = ['app_name', 'contact_email', 'global_email', 'email_from', 'name_from',
                 'email_type', 'smtp_host', 'smtp_user', 'smtp_pass', 'smtp_port', 'smtp_encryption'];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(
                    ['key' => $key, 'tenant_id' => null],
                    ['value' => $request->input($key)]
                );
            }
        }

        return back()->with('success', 'General settings updated.');
    }

    public function api()
    {
        $settings = Setting::whereNull('tenant_id')->pluck('value', 'key')->toArray();
        return view('superadmin.settings.api', compact('settings'));
    }

    public function updateApi(Request $request)
    {
        $keys = ['openai_api_key', 'default_ai_model', 'token_rate', 'credits_per_dollar'];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                $value = $key === 'openai_api_key' && $request->input($key)
                    ? encrypt($request->input($key))
                    : $request->input($key);

                Setting::updateOrCreate(
                    ['key' => $key, 'tenant_id' => null],
                    ['value' => $value]
                );
            }
        }

        return back()->with('success', 'API & credit settings updated.');
    }

    public function pricing()
    {
        $settings = Setting::whereNull('tenant_id')->pluck('value', 'key')->toArray();
        return view('superadmin.settings.pricing', compact('settings'));
    }

    public function updatePricing(Request $request)
    {
        $keys = ['min_plan_price_monthly', 'min_plan_price_yearly', 'min_credit_price'];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(
                    ['key' => $key, 'tenant_id' => null],
                    ['value' => $request->input($key)]
                );
            }
        }

        return back()->with('success', 'Minimum price rules updated.');
    }
}
