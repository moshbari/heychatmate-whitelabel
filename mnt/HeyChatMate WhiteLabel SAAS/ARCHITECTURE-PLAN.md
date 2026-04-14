# HeyChatMate White-Label SaaS — Architecture Plan

## Overview

Transform the existing HeyChatMate single-tenant Laravel app into a full **multi-tenant white-label SaaS platform** where:

- **You (Mosh)** are the **Super Admin** — you own the platform
- **Tenants** are your customers — they buy the white-label service from you
- **Sub-Users** are the tenant's customers — they use the platform under the tenant's brand

Each tenant gets their own branded version of HeyChatMate running on their custom domain, with their own logo, app name, and users — while you control everything from a single codebase and database.

---

## Architecture: Shared Database, Tenant-Scoped

We will use a **single database with tenant isolation** approach (not separate databases per tenant). This is the most practical for a Laravel app and scales well to hundreds of tenants.

Every tenant-owned record gets a `tenant_id` foreign key. A global middleware resolves which tenant the request belongs to (from domain) and scopes all queries automatically.

---

## 1. New Database Tables & Models

### 1.1 `tenants` table (NEW)

This is the core of the multi-tenant system. Each row = one white-label customer.

```
tenants
├── id (PK, bigint, auto-increment)
├── owner_id (FK → users.id) — the user who owns this tenant
├── name (string) — tenant's business name
├── slug (string, unique) — subdomain identifier (e.g., "acme" → acme.heychatmate.com)
├── custom_domain (string, nullable, unique) — e.g., "chat.acmecorp.com"
├── domain_verified (boolean, default: false) — DNS verification status
├── domain_verification_token (string, nullable) — TXT record token for verification
│
│ — Branding —
├── app_name (string, default: "HeyChatMate") — displayed app name
├── logo (string, nullable) — path to custom logo image
├── favicon (string, nullable) — path to custom favicon
├── primary_color (string, default: "#696cff") — brand color hex
├── secondary_color (string, nullable)
├── login_bg_image (string, nullable) — custom login page background
├── footer_text (string, nullable) — custom footer text
│
│ — API Configuration —
├── api_mode (enum: 'platform', 'own') — use platform credits or own API key
├── openai_api_key (string, nullable, encrypted) — tenant's own OpenAI key
├── ai_model (string, default: "gpt-3.5-turbo-16k") — preferred model
├── credit_balance (decimal, default: 0) — tenant's credit pool (when using platform API)
│
│ — Limits & Plan —
├── plan_id (FK → tenant_plans.id, nullable)
├── max_users (integer, default: 5) — max sub-users allowed
├── max_bots_per_user (integer, default: 3) — max assistants per sub-user
├── status (enum: 'active', 'suspended', 'trial', 'cancelled')
├── trial_ends_at (timestamp, nullable)
│
│ — Payment Gateway (tenant's own Stripe for billing their users) —
├── stripe_key (string, nullable, encrypted)
├── stripe_secret (string, nullable, encrypted)
├── stripe_webhook_secret (string, nullable, encrypted)
│
├── created_at
├── updated_at
```

### 1.2 `tenant_plans` table (NEW)

Plans that YOU sell to tenants (not to end-users).

```
tenant_plans
├── id (PK)
├── name (string) — e.g., "Starter", "Pro", "Enterprise"
├── price (decimal)
├── billing_cycle (enum: 'monthly', 'yearly', 'one-time')
├── max_users (integer) — user seat limit
├── max_bots_per_user (integer)
├── credits_included (integer) — monthly credit allocation
├── custom_domain_allowed (boolean)
├── own_api_key_allowed (boolean)
├── white_label_full (boolean) — remove "Powered by HeyChatMate" badge
├── features (json, nullable) — extra feature flags
├── status (boolean, default: true)
├── created_at
├── updated_at
```

### 1.3 `tenant_subscriptions` table (NEW)

Tracks tenant subscription status with you.

```
tenant_subscriptions
├── id (PK)
├── tenant_id (FK → tenants.id)
├── tenant_plan_id (FK → tenant_plans.id)
├── amount (decimal)
├── cycle (enum: 'monthly', 'yearly', 'one-time')
├── due_date (datetime)
├── payment_method (string)
├── stripe_subscription_id (string, nullable) — for recurring billing
├── status (enum: 'active', 'expired', 'cancelled', 'past_due')
├── created_at
├── updated_at
```

### 1.4 `tenant_transactions` table (NEW)

Credit purchase history for tenants buying from you.

```
tenant_transactions
├── id (PK)
├── trx_id (string, unique)
├── tenant_id (FK → tenants.id)
├── amount (decimal)
├── credits (integer)
├── type (enum: '+', '-')
├── remark (string) — 'credit_purchase', 'usage_deduction', 'plan_allocation'
├── details (text)
├── status (boolean)
├── created_at
├── updated_at
```

### 1.5 Modifications to Existing `users` table

Add these columns:

```
users (MODIFIED)
├── tenant_id (FK → tenants.id, nullable) — null for super admin & tenant owners before setup
├── role (enum: 'super_admin', 'tenant_owner', 'tenant_admin', 'user') — replaces 'type' field
├── invited_by (FK → users.id, nullable) — who invited this user
├── last_login_at (timestamp, nullable)
```

**Role hierarchy:**
- `super_admin` — You (Mosh). Full platform control. No tenant_id.
- `tenant_owner` — Your customer who bought white-label. Has tenant_id pointing to their tenant.
- `tenant_admin` — Co-admin added by tenant owner. Same tenant_id.
- `user` — End-user (sub-user) of a tenant. Has tenant_id.

### 1.6 Modifications to Existing Tables

All tenant-scoped tables need a `tenant_id` column:

```
chat_assistants   → ADD tenant_id (FK → tenants.id)
chats             → ADD tenant_id (FK → tenants.id)  
conversations     → (inherits tenant scope via chat)
plans             → ADD tenant_id (FK → tenants.id, nullable) — null = platform-level plans
user_subscriptions → ADD tenant_id (FK → tenants.id, nullable)
transactions      → ADD tenant_id (FK → tenants.id, nullable)
user_payments     → ADD tenant_id (FK → tenants.id, nullable)
settings          → ADD tenant_id (FK → tenants.id, nullable) — null = global settings
pages             → ADD tenant_id (FK → tenants.id, nullable)
faqs              → ADD tenant_id (FK → tenants.id, nullable)
homepage_contents → ADD tenant_id (FK → tenants.id, nullable)
form_fields       → (inherits tenant scope via chat_assistant)
ai_instructions   → (inherits tenant scope via chat_assistant)
user_configs      → ADD tenant_id (FK → tenants.id, nullable)
auto_responders   → ADD tenant_id (FK → tenants.id, nullable)
```

---

## 2. Domain & Routing System

### 2.1 How Custom Domains Work

**Three ways a tenant's platform is accessed:**

1. **Default subdomain**: `{slug}.heychatmate.com` (always available)
2. **Custom domain**: `chat.acmecorp.com` (optional, verified via DNS)
3. **Platform domain**: `heychatmate.com` (super admin panel + landing page)

### 2.2 Domain Verification Flow

When a tenant adds a custom domain:

1. System generates a unique `domain_verification_token`
2. Tenant adds a DNS TXT record: `_heychatmate-verify.chat.acmecorp.com → token`
3. Tenant also adds a CNAME: `chat.acmecorp.com → tenants.heychatmate.com`
4. System runs a verification check (cron job or manual button)
5. Once verified, `domain_verified = true` and domain goes live

### 2.3 Nginx Configuration

```nginx
# Catch-all server block for tenant domains
server {
    listen 80;
    server_name *.heychatmate.com;  # subdomains
    # ... proxy to Laravel
}

server {
    listen 80;
    server_name ~^(?<domain>.+)$;  # catch custom domains
    # ... proxy to Laravel
}

# SSL via Let's Encrypt with wildcard + per-domain certs
# Use Caddy or certbot with DNS challenge for automation
```

### 2.4 Tenant Resolution Middleware

**New file:** `app/Http/Middleware/ResolveTenant.php`

```
Request comes in → 
  1. Extract hostname from request
  2. Check: is it the main platform domain? → Super Admin routes
  3. Check: is it a subdomain of heychatmate.com? → Extract slug, find tenant by slug
  4. Check: is it a custom domain? → Find tenant by custom_domain where domain_verified = true
  5. Tenant found? → Bind tenant to request/app container, continue
  6. Tenant not found? → 404 page
```

This middleware runs on EVERY request (except the super admin panel). It sets the current tenant in Laravel's service container so all queries can scope to it.

### 2.5 Automatic Query Scoping

**New trait:** `app/Traits/BelongsToTenant.php`

Applied to all tenant-scoped models. Automatically:
- Adds `WHERE tenant_id = ?` to all SELECT queries
- Sets `tenant_id` on INSERT operations
- Prevents cross-tenant data access

```php
trait BelongsToTenant {
    protected static function bootBelongsToTenant() {
        static::addGlobalScope('tenant', function ($query) {
            if ($tenant = app('current_tenant')) {
                $query->where('tenant_id', $tenant->id);
            }
        });
        
        static::creating(function ($model) {
            if ($tenant = app('current_tenant')) {
                $model->tenant_id = $tenant->id;
            }
        });
    }
}
```

---

## 3. User Roles & Permissions

### 3.1 Role Hierarchy

```
SUPER ADMIN (Mosh)
│
├── Manage all tenants (create, suspend, delete)
├── Manage tenant plans & pricing
├── View all platform revenue & analytics
├── Global settings (platform API key, default branding)
├── Impersonate any tenant for support
│
└── TENANT OWNER (Your Customer)
    │
    ├── Branding settings (name, logo, colors, favicon)
    ├── Custom domain setup
    ├── API key configuration (own vs platform)
    ├── Credit management (buy credits, view usage)
    ├── Plan management for their users (create plans, pricing)
    ├── User management (invite, suspend, delete sub-users)
    ├── View tenant-level analytics
    ├── Payment gateway setup (their own Stripe)
    │
    ├── TENANT ADMIN (Co-admin)
    │   ├── Same as tenant owner except:
    │   ├── Cannot change billing/payment settings
    │   └── Cannot delete the tenant
    │
    └── USER (End-user / Sub-user)
        ├── Create & manage chatbot assistants
        ├── View their own chats & conversations
        ├── Manage their own subscription (plans set by tenant)
        ├── Configure own API key (if tenant allows)
        └── View their own credit history
```

### 3.2 Middleware Stack

```
Route Groups:
├── Super Admin routes → auth + isSuperAdmin middleware
├── Tenant Owner routes → auth + ResolveTenant + isTenantOwner middleware  
├── Tenant Admin routes → auth + ResolveTenant + isTenantAdmin middleware
├── User routes → auth + ResolveTenant + auth middleware
├── Public/Widget routes → ResolveTenant middleware (no auth)
```

---

## 4. Branding System

### 4.1 What Tenants Can Customize

From their **Tenant Dashboard → Branding** page:

| Setting | Storage | Effect |
|---------|---------|--------|
| App Name | `tenants.app_name` | Shown in navbar, page titles, emails |
| Logo | `tenants.logo` (file path) | Navbar, login page, emails |
| Favicon | `tenants.favicon` (file path) | Browser tab icon |
| Primary Color | `tenants.primary_color` | Buttons, links, nav background |
| Secondary Color | `tenants.secondary_color` | Accents, hover states |
| Login Background | `tenants.login_bg_image` | Login/register page background |
| Footer Text | `tenants.footer_text` | Page footer content |

### 4.2 How Branding Is Applied

**Blade views** will use a helper that reads from the current tenant:

```php
// In views:
{{ tenant_setting('app_name') }}   // instead of get_settings('site_name')
{{ tenant_asset('logo') }}          // tenant's logo URL
{{ tenant_setting('primary_color') }} // for CSS variables
```

**CSS injection** via a `<style>` block in the layout that sets CSS custom properties:

```css
:root {
    --primary-color: {{ tenant_setting('primary_color', '#696cff') }};
    --secondary-color: {{ tenant_setting('secondary_color', '#8592a3') }};
}
```

The existing Sneat template's color classes already use CSS variables, so this integrates cleanly.

### 4.3 File Storage

Tenant assets stored at: `storage/app/tenants/{tenant_id}/branding/`
- `logo.png`
- `favicon.ico`
- `login-bg.jpg`

---

## 5. Credit & API Key System

### 5.1 Two Modes for Tenants

**Mode A — Platform API (Credits)**
```
Mosh's OpenAI Key → Tenant buys credits from Mosh → 
  Tenant distributes credits to sub-users → 
  Sub-users use chatbots → Credits deducted from sub-user → 
  When sub-user balance runs out, deduct from tenant pool (configurable)
```

**Mode B — Own API Key**
```
Tenant provides their own OpenAI API key → 
  All sub-users under this tenant use that key → 
  No credits deducted → Tenant pays OpenAI directly
```

### 5.2 Credit Flow (Mode A)

```
┌─────────────┐     Buy Credits      ┌──────────┐    Distribute    ┌──────────┐
│  Mosh's     │ ──────────────────►   │  Tenant  │ ─────────────►  │ Sub-User │
│  Platform   │   (Stripe/PayPal)     │  Balance │   (Manual or    │ Balance  │
│             │                       │          │    Auto-assign)  │          │
└─────────────┘                       └──────────┘                  └──────────┘
                                                                         │
                                                                    Uses Chatbot
                                                                         │
                                                                    ▼ Credits 
                                                                    Deducted
```

**Credit deduction logic (updated):**

```php
// In PusherController@broadcasto - MODIFIED
if ($tenant->api_mode == 'own') {
    // Use tenant's own key — no credits
    $api_key = decrypt($tenant->openai_api_key);
    $ai_model = $tenant->ai_model;
} else {
    // Use platform key — deduct credits
    $api_key = get_settings('system_api_key');
    $ai_model = get_settings('system_ai_model');
    
    $token_used = $response['usage']['total_tokens'];
    $balance_used = round(convertTokens($token_used));
    
    // Deduct from user first, then tenant pool if user is out
    cutBalance($user->id, $balance_used, $assistant->name);
}
```

### 5.3 Tenant Credit Purchase

Tenants buy credits from you via the existing Stripe/PayPal integration. New endpoint:

```
POST /tenant/credits/purchase
→ Amount selection
→ Payment via Stripe/PayPal
→ Credits added to tenants.credit_balance
→ tenant_transactions record created
```

### 5.4 Sub-User API Key Option

If the **tenant allows it** (configurable), individual sub-users can ALSO add their own OpenAI API key:

```
Priority:
1. User has own API key in UserConfig → Use it (no credits)
2. Tenant has own API key (api_mode = 'own') → Use tenant key (no credits)
3. Otherwise → Use platform API key (deduct credits)
```

---

## 6. Sub-User (Seat) Management

### 6.1 How Tenants Sell Spots

Tenants manage their users from **Tenant Dashboard → Users**:

1. **Invite by email** — sends branded invite email with registration link
2. **Manual create** — tenant creates user account directly
3. **Self-registration** — tenant can enable/disable public registration on their domain

### 6.2 Seat Limits

Controlled by the tenant's plan (`tenant_plans.max_users`):
- Tenant on "Starter" plan → max 5 users
- Tenant on "Pro" plan → max 50 users
- Tenant on "Enterprise" → unlimited

### 6.3 Tenant-Level Plans for Sub-Users

Tenants can create their OWN plans for their sub-users:

```
plans table (MODIFIED with tenant_id)
├── tenant_id = NULL → Platform-level plans (Mosh's plans for tenants)
├── tenant_id = 5   → Plans created by Tenant #5 for their sub-users
```

This means tenant #5 can create:
- "Free" plan: 100 credits, 1 bot
- "Basic" plan: 1000 credits, 3 bots, $9/mo
- "Premium" plan: 5000 credits, 10 bots, $29/mo

**Billing for sub-user plans:**
- If tenant has their own Stripe keys → payments go to tenant's Stripe
- If not → tenant manages billing manually (credits allocation)

---

## 7. Route Structure (Revised)

```php
// === SUPER ADMIN ROUTES ===
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard']);
    Route::resource('/tenants', TenantManagementController::class);
    Route::resource('/tenant-plans', TenantPlanController::class);
    Route::get('/revenue', [RevenueController::class, 'index']);
    Route::get('/all-users', [SuperAdminUserController::class, 'index']);
    Route::post('/impersonate/{tenant}', [ImpersonateController::class, 'start']);
    // ... existing admin routes for global settings
});

// === TENANT OWNER ROUTES ===
Route::middleware(['auth', 'tenant.resolved', 'tenant.owner'])->prefix('tenant')->group(function () {
    Route::get('/dashboard', [TenantDashboardController::class, 'index']);
    
    // Branding
    Route::get('/branding', [BrandingController::class, 'index']);
    Route::post('/branding/update', [BrandingController::class, 'update']);
    
    // Domain
    Route::get('/domain', [DomainController::class, 'index']);
    Route::post('/domain/update', [DomainController::class, 'update']);
    Route::post('/domain/verify', [DomainController::class, 'verify']);
    
    // Users (sub-users)
    Route::resource('/users', TenantUserController::class);
    Route::post('/users/invite', [TenantUserController::class, 'invite']);
    
    // Plans for sub-users
    Route::resource('/plans', TenantPlanConfigController::class);
    
    // Credits
    Route::get('/credits', [TenantCreditController::class, 'index']);
    Route::post('/credits/purchase', [TenantCreditController::class, 'purchase']);
    Route::post('/credits/distribute', [TenantCreditController::class, 'distribute']);
    
    // API Settings
    Route::get('/api-settings', [TenantApiController::class, 'index']);
    Route::post('/api-settings/update', [TenantApiController::class, 'update']);
    
    // Payment Gateway (tenant's own Stripe)
    Route::get('/payment-settings', [TenantPaymentController::class, 'index']);
    Route::post('/payment-settings/update', [TenantPaymentController::class, 'update']);
    
    // Analytics
    Route::get('/analytics', [TenantAnalyticsController::class, 'index']);
});

// === SUB-USER ROUTES (existing user routes, now tenant-scoped) ===
Route::middleware(['auth', 'tenant.resolved'])->group(function () {
    // All existing user routes remain the same
    // They automatically scope to tenant via BelongsToTenant trait
    Route::get('/user/dashboard', [DashboardController::class, 'index']);
    Route::get('/manage-assistants', [AssistantController::class, 'index']);
    // ... etc (all existing user routes)
});

// === PUBLIC TENANT-SCOPED ROUTES ===
Route::middleware(['tenant.resolved'])->group(function () {
    Route::get('/', [TenantFrontController::class, 'home']);
    Route::get('/login', [TenantAuthController::class, 'showLogin']);
    Route::post('/login', [TenantAuthController::class, 'login']);
    Route::get('/register', [TenantAuthController::class, 'showRegister']);
    Route::post('/register', [TenantAuthController::class, 'register']);
    // Chat widget routes...
});
```

---

## 8. New Files & Controllers to Create

### Controllers (NEW)
```
app/Http/Controllers/
├── SuperAdmin/
│   ├── SuperAdminDashboardController.php
│   ├── TenantManagementController.php
│   ├── TenantPlanController.php
│   ├── RevenueController.php
│   ├── ImpersonateController.php
│   └── SuperAdminSettingsController.php
├── Tenant/
│   ├── TenantDashboardController.php
│   ├── BrandingController.php
│   ├── DomainController.php
│   ├── TenantUserController.php
│   ├── TenantPlanConfigController.php
│   ├── TenantCreditController.php
│   ├── TenantApiController.php
│   ├── TenantPaymentController.php
│   └── TenantAnalyticsController.php
```

### Middleware (NEW)
```
app/Http/Middleware/
├── ResolveTenant.php         — resolves tenant from domain
├── IsSuperAdmin.php          — checks role = super_admin
├── IsTenantOwner.php         — checks role = tenant_owner or tenant_admin
├── EnsureTenantActive.php    — checks tenant status is active
```

### Models (NEW)
```
app/Models/
├── Tenant.php
├── TenantPlan.php
├── TenantSubscription.php
├── TenantTransaction.php
```

### Traits (NEW)
```
app/Traits/
├── BelongsToTenant.php       — auto-scoping trait for all tenant models
```

### Migrations (NEW)
```
database/migrations/
├── xxxx_create_tenant_plans_table.php
├── xxxx_create_tenants_table.php
├── xxxx_create_tenant_subscriptions_table.php
├── xxxx_create_tenant_transactions_table.php
├── xxxx_add_tenant_id_to_users_table.php
├── xxxx_add_tenant_id_to_chat_assistants_table.php
├── xxxx_add_tenant_id_to_chats_table.php
├── xxxx_add_tenant_id_to_plans_table.php
├── xxxx_add_tenant_id_to_settings_table.php
├── xxxx_add_tenant_id_to_remaining_tables.php
```

### Views (NEW)
```
resources/views/
├── superadmin/               — Super admin panel views
│   ├── dashboard.blade.php
│   ├── tenants/
│   ├── tenant-plans/
│   └── settings/
├── tenant/                   — Tenant owner panel views
│   ├── dashboard.blade.php
│   ├── branding.blade.php
│   ├── domain.blade.php
│   ├── users/
│   ├── plans/
│   ├── credits.blade.php
│   ├── api-settings.blade.php
│   └── analytics.blade.php
├── layouts/
│   └── tenant-app.blade.php  — Tenant-branded layout (reads from tenant settings)
```

---

## 9. Implementation Phases

### Phase 1 — Foundation (Week 1-2)
- [ ] Create all new migrations & run them
- [ ] Create Tenant, TenantPlan, TenantSubscription, TenantTransaction models
- [ ] Create BelongsToTenant trait
- [ ] Create ResolveTenant middleware
- [ ] Add tenant_id to all existing tables
- [ ] Update User model with role field
- [ ] Update Helpers.php with tenant-aware functions
- [ ] Basic tenant CRUD in super admin panel

### Phase 2 — Tenant Dashboard (Week 2-3)
- [ ] Tenant owner authentication & routing
- [ ] Branding settings page (name, logo, colors)
- [ ] Tenant-branded Blade layout
- [ ] User management (invite, create, suspend sub-users)
- [ ] Tenant-level plan creation for sub-users

### Phase 3 — Custom Domains (Week 3-4)
- [ ] Domain management UI
- [ ] DNS verification logic
- [ ] Nginx config automation (or Caddy auto-SSL)
- [ ] Subdomain routing
- [ ] SSL certificate provisioning

### Phase 4 — Credits & Billing (Week 4-5)
- [ ] Tenant credit purchase flow
- [ ] Credit distribution to sub-users
- [ ] Updated OpenAI API key resolution logic
- [ ] Tenant's own Stripe integration for billing sub-users
- [ ] Transaction history & reporting

### Phase 5 — Polish & Launch (Week 5-6)
- [ ] Tenant analytics dashboard
- [ ] Email templates with tenant branding
- [ ] Impersonation feature for support
- [ ] Rate limiting & abuse prevention
- [ ] Testing across multiple tenant domains
- [ ] Documentation for tenants

---

## 10. Server Requirements (Contabo)

The existing Contabo server needs:
- **Nginx** or **Caddy** (Caddy recommended for automatic SSL with custom domains)
- **PHP 8.1+** with required extensions
- **MySQL 8.0**
- **Redis** (recommended for caching tenant resolution)
- **Supervisor** for queue workers
- **Certbot** or Caddy for SSL certificates
- **DNS**: Wildcard A record for `*.heychatmate.com` pointing to Contabo IP

---

## 11. Security Considerations

1. **Tenant isolation** — BelongsToTenant trait prevents cross-tenant data leaks
2. **API key encryption** — All stored API keys encrypted at rest using Laravel's `encrypt()`
3. **Domain verification** — Prevents domain hijacking via DNS TXT verification
4. **Rate limiting** — Per-tenant rate limits to prevent abuse
5. **Impersonation audit log** — Log all super admin impersonation sessions
6. **CSRF** — Maintained across all tenant domains
7. **Session isolation** — Sessions scoped to tenant domain to prevent cross-tenant login

---

## Summary

This architecture transforms HeyChatMate from a single-instance app into a scalable white-label SaaS with:

- **Multi-tenant isolation** via shared database + automatic query scoping
- **Custom domains** with DNS verification and auto-SSL
- **Full branding control** for tenants (name, logo, colors, favicon)
- **Flexible billing** — tenants buy credits from you OR use their own API key
- **Sub-user management** — tenants sell seats and create their own pricing plans
- **Clean role hierarchy** — Super Admin → Tenant Owner → Tenant Admin → User

The existing codebase stays ~80% intact. Most changes are additive (new models, middleware, controllers, views) with surgical modifications to existing code (adding tenant_id scoping and updating the API key resolution logic).
