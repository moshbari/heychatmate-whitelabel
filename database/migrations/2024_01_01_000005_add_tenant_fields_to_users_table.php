<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->after('id');
            $table->enum('role', ['super_admin', 'tenant_owner', 'tenant_admin', 'user'])->default('user')->after('type');
            $table->unsignedBigInteger('invited_by')->nullable()->after('role');
            $table->timestamp('last_login_at')->nullable()->after('updated_at');

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('invited_by')->references('id')->on('users')->onDelete('set null');
            $table->index('tenant_id');
            $table->index('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropForeign(['invited_by']);
            $table->dropIndex(['tenant_id']);
            $table->dropIndex(['role']);
            $table->dropColumn(['tenant_id', 'role', 'invited_by', 'last_login_at']);
        });
    }
};
