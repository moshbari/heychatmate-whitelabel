<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('custom_domain')->nullable()->unique();
            $table->boolean('domain_verified')->default(false);
            $table->string('domain_verification_token')->nullable();

            // Branding
            $table->string('app_name')->default('HeyChatMate');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('primary_color', 20)->default('#696cff');
            $table->string('secondary_color', 20)->nullable();
            $table->string('login_bg_image')->nullable();
            $table->text('footer_text')->nullable();

            // API Configuration
            $table->enum('api_mode', ['platform', 'own'])->default('platform');
            $table->text('openai_api_key')->nullable(); // encrypted at app level
            $table->string('ai_model')->default('gpt-3.5-turbo-16k');
            $table->decimal('credit_balance', 12, 2)->default(0);

            // Limits & Plan
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->integer('max_users')->default(5);
            $table->integer('max_bots_per_user')->default(3);
            $table->enum('status', ['active', 'suspended', 'trial', 'cancelled'])->default('trial');
            $table->timestamp('trial_ends_at')->nullable();

            // Payment Gateway - tenant's own processor for billing their users
            $table->enum('payment_processor', ['stripe', 'jvzoo', 'whop'])->nullable();
            $table->text('stripe_key')->nullable();
            $table->text('stripe_secret')->nullable();
            $table->text('stripe_webhook_secret')->nullable();
            $table->text('jvzoo_secret_key')->nullable();
            $table->text('jvzoo_api_key')->nullable();
            $table->text('whop_api_key')->nullable();
            $table->string('whop_company_id')->nullable();
            $table->text('whop_webhook_secret')->nullable();
            $table->boolean('min_price_override')->default(false);

            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('tenant_plans')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
