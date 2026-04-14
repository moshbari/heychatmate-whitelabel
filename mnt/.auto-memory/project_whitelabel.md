---
name: White-Label SaaS Transformation
description: Converting HeyChatMate from single-tenant to multi-tenant white-label SaaS with custom domains, branding, sub-users, and credit system
type: project
---

Transforming HeyChatMate (Laravel 10, MySQL, Bootstrap/Sneat, Pusher, Stripe/PayPal) into a multi-tenant white-label SaaS.

**Why:** Mosh wants to sell the platform as a white-label service where customers run their own branded AI chatbot platforms.

**How to apply:** All development should follow the architecture plan saved at ARCHITECTURE-PLAN.md in the workspace folder. Key decisions: shared database with tenant_id scoping, BelongsToTenant trait, ResolveTenant middleware, custom domain via DNS CNAME + verification, 4-role hierarchy (super_admin → tenant_owner → tenant_admin → user).

Original repo: https://github.com/moshbari/heychatmate.git
Working clone at: /sessions/epic-keen-keller/heychatmate-whitelabel/
