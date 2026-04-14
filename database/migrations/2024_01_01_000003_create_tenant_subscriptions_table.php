<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('tenant_plan_id');
            $table->decimal('amount', 10, 2);
            $table->enum('cycle', ['monthly', 'yearly', 'one-time']);
            $table->timestamp('due_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->enum('status', ['active', 'expired', 'cancelled', 'past_due'])->default('active');
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('tenant_plan_id')->references('id')->on('tenant_plans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_subscriptions');
    }
};
