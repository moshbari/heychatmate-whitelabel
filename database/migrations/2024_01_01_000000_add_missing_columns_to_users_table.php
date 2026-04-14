<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The original HeyChatMate app had these columns added manually (not via migrations).
 * This migration ensures they exist in a fresh database.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'type')) {
                $table->string('type')->default('user')->after('email');
            }
            if (!Schema::hasColumn('users', 'email_verified')) {
                $table->boolean('email_verified')->default(false)->after('type');
            }
            if (!Schema::hasColumn('users', 'credit_balance')) {
                $table->decimal('credit_balance', 12, 2)->default(0)->after('email_verified');
            }
            if (!Schema::hasColumn('users', 'subscription_id')) {
                $table->unsignedBigInteger('subscription_id')->nullable()->after('credit_balance');
            }
            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable()->after('subscription_id');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('country');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->boolean('status')->default(true)->after('phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['type', 'email_verified', 'credit_balance', 'subscription_id', 'country', 'phone', 'status'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
