<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'custom_domain',
        'domain_verified',
        'domain_verification_token',
        // Branding
        'app_name',
        'logo',
        'favicon',
        'primary_color',
        'secondary_color',
        'login_bg_image',
        'footer_text',
        // API Configuration
        'api_mode',
        'openai_api_key',
        'ai_model',
        'credit_balance',
        // Limits & Plan
        'plan_id',
        'max_users',
        'max_bots_per_user',
        'status',
        'trial_ends_at',
        // Payment Gateway
        'payment_processor',
        'stripe_key',
        'stripe_secret',
        'stripe_webhook_secret',
        'jvzoo_secret_key',
        'jvzoo_api_key',
        'whop_api_key',
        'whop_company_id',
        'whop_webhook_secret',
        'min_price_override',
    ];

    protected $casts = [
        'domain_verified' => 'boolean',
        'credit_balance' => 'decimal:2',
        'min_price_override' => 'boolean',
        'trial_ends_at' => 'datetime',
    ];

    /**
     * Sensitive fields that should be encrypted/hidden.
     */
    protected $hidden = [
        'openai_api_key',
        'stripe_key',
        'stripe_secret',
        'stripe_webhook_secret',
        'jvzoo_secret_key',
        'jvzoo_api_key',
        'whop_api_key',
        'whop_webhook_secret',
    ];

    // ── Relationships ──

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function plan()
    {
        return $this->belongsTo(TenantPlan::class, 'plan_id');
    }

    public function subscription()
    {
        return $this->hasOne(TenantSubscription::class)->latest();
    }

    public function subscriptions()
    {
        return $this->hasMany(TenantSubscription::class);
    }

    public function transactions()
    {
        return $this->hasMany(TenantTransaction::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    public function assistants()
    {
        return $this->hasMany(ChatAssistant::class, 'tenant_id');
    }

    // ── Helper Methods ──

    /**
     * Check if tenant has an active subscription or valid trial.
     */
    public function isActive(): bool
    {
        if ($this->status === 'active') {
            return true;
        }

        if ($this->status === 'trial' && $this->trial_ends_at && $this->trial_ends_at->isFuture()) {
            return true;
        }

        return false;
    }

    /**
     * Check if tenant can add more users.
     */
    public function canAddUser(): bool
    {
        return $this->users()->count() < $this->max_users;
    }

    /**
     * Check if a sub-user can add more bots.
     */
    public function canUserAddBot(User $user): bool
    {
        return $user->assistant()->count() < $this->max_bots_per_user;
    }

    /**
     * Get the full domain for this tenant.
     */
    public function getDomainAttribute(): string
    {
        if ($this->domain_verified && $this->custom_domain) {
            return $this->custom_domain;
        }

        return $this->slug . '.whitelabel.heychatmate.com';
    }

    /**
     * Get the full URL for this tenant.
     */
    public function getUrlAttribute(): string
    {
        return 'https://' . $this->domain;
    }

    /**
     * Check if tenant uses their own API key.
     */
    public function usesOwnApiKey(): bool
    {
        return $this->api_mode === 'own' && !empty($this->openai_api_key);
    }

    /**
     * Get the decrypted OpenAI API key.
     */
    public function getDecryptedApiKey(): ?string
    {
        if ($this->openai_api_key) {
            try {
                return decrypt($this->openai_api_key);
            } catch (\Exception $e) {
                return $this->openai_api_key; // fallback if not encrypted
            }
        }

        return null;
    }

    /**
     * Deduct credits from tenant pool.
     */
    public function deductCredits(float $amount, string $details = ''): bool
    {
        if ($this->credit_balance < $amount) {
            return false;
        }

        $this->decrement('credit_balance', $amount);

        $this->transactions()->create([
            'trx_id' => str_rand(),
            'amount' => $amount,
            'credits' => (int) $amount,
            'type' => '-',
            'remark' => 'usage_deduction',
            'details' => $details,
            'status' => true,
        ]);

        return true;
    }

    /**
     * Add credits to tenant pool.
     */
    public function addCredits(float $amount, string $remark = 'credit_purchase', string $details = ''): void
    {
        $this->increment('credit_balance', $amount);

        $this->transactions()->create([
            'trx_id' => str_rand(),
            'amount' => $amount,
            'credits' => (int) $amount,
            'type' => '+',
            'remark' => $remark,
            'details' => $details,
            'status' => true,
        ]);
    }

    /**
     * Resolve a tenant by domain (custom domain or subdomain slug).
     */
    public static function resolveFromDomain(string $host): ?self
    {
        // Check custom domain first
        $tenant = static::where('custom_domain', $host)
            ->where('domain_verified', true)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($tenant) {
            return $tenant;
        }

        // Check subdomain: {slug}.whitelabel.heychatmate.com
        $baseDomain = 'whitelabel.heychatmate.com';
        if (str_ends_with($host, '.' . $baseDomain)) {
            $slug = str_replace('.' . $baseDomain, '', $host);
            return static::where('slug', $slug)
                ->where('status', '!=', 'cancelled')
                ->first();
        }

        return null;
    }
}
