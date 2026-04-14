<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DomainController extends Controller
{
    public function index()
    {
        $tenant = current_tenant();
        return view('tenant.branding.domain', compact('tenant'));
    }

    public function update(Request $request)
    {
        $tenant = current_tenant();

        $request->validate([
            'custom_domain' => 'required|string|max:255',
        ]);

        $domain = strtolower(trim($request->custom_domain));

        // Basic domain validation
        if (!preg_match('/^(?!:\/\/)(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $domain)) {
            return redirect()->back()->with('error', 'Please enter a valid domain name.');
        }

        // Check if domain is already taken by another tenant
        $existing = \App\Models\Tenant::where('custom_domain', $domain)
            ->where('id', '!=', $tenant->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'This domain is already in use by another workspace.');
        }

        // Generate verification token if new domain
        if ($tenant->custom_domain !== $domain) {
            $tenant->custom_domain = $domain;
            $tenant->domain_verified = false;
            $tenant->domain_verification_token = Str::random(32);
        }

        $tenant->save();

        return redirect()->back()->with('success', 'Domain updated. Please add the DNS records below and click Verify.');
    }

    public function verify(Request $request)
    {
        $tenant = current_tenant();

        if (!$tenant->custom_domain || !$tenant->domain_verification_token) {
            return redirect()->back()->with('error', 'No domain configured to verify.');
        }

        // Check CNAME record
        $cnameValid = false;
        $txtValid = false;

        // Verify CNAME points to our platform
        $cnameRecords = @dns_get_record($tenant->custom_domain, DNS_CNAME);
        if ($cnameRecords) {
            foreach ($cnameRecords as $record) {
                if (isset($record['target']) &&
                    str_contains($record['target'], 'whitelabel.heychatmate.com')) {
                    $cnameValid = true;
                    break;
                }
            }
        }

        // Also accept A record pointing to our server IP
        if (!$cnameValid) {
            $aRecords = @dns_get_record($tenant->custom_domain, DNS_A);
            if ($aRecords) {
                foreach ($aRecords as $record) {
                    if (isset($record['ip']) && $record['ip'] === '109.205.182.135') {
                        $cnameValid = true;
                        break;
                    }
                }
            }
        }

        // Verify TXT record
        $txtRecords = @dns_get_record('_heychatmate-verify.' . $tenant->custom_domain, DNS_TXT);
        if ($txtRecords) {
            foreach ($txtRecords as $record) {
                if (isset($record['txt']) && $record['txt'] === $tenant->domain_verification_token) {
                    $txtValid = true;
                    break;
                }
            }
        }

        if ($cnameValid && $txtValid) {
            $tenant->domain_verified = true;
            $tenant->save();
            return redirect()->back()->with('success', 'Domain verified successfully! Your custom domain is now active.');
        }

        $errors = [];
        if (!$cnameValid) {
            $errors[] = 'CNAME or A record not found. Make sure ' . $tenant->custom_domain . ' points to whitelabel.heychatmate.com or 109.205.182.135';
        }
        if (!$txtValid) {
            $errors[] = 'TXT verification record not found. Add a TXT record for _heychatmate-verify.' . $tenant->custom_domain;
        }

        return redirect()->back()->with('error', 'Verification failed: ' . implode(' | ', $errors));
    }

    public function removeDomain()
    {
        $tenant = current_tenant();
        $tenant->custom_domain = null;
        $tenant->domain_verified = false;
        $tenant->domain_verification_token = null;
        $tenant->save();

        return redirect()->back()->with('success', 'Custom domain removed. Your workspace is now accessible via your subdomain.');
    }
}
