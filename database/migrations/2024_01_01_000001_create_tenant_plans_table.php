<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->enum('billing_cycle', ['monthly', 'yearly', 'one-time']);
            $table->integer('max_users')->default(5);
            $table->integer('max_bots_per_user')->default(3);
            $table->integer('credits_included')->default(0);
            $table->boolean('custom_domain_allowed')->default(false);
            $table->boolean('own_api_key_allowed')->default(false);
            $table->boolean('white_label_full')->default(false);
            $table->json('features')->nullable();
            $table->string('subtitle')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_plans');
    }
};
