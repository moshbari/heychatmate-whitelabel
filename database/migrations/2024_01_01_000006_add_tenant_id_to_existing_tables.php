<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables that need tenant_id for multi-tenant scoping.
     * Some tables inherit tenant scope via relationships (conversations via chats,
     * form_fields & ai_instructions via chat_assistants), so they don't need their own tenant_id.
     */
    private array $tables = [
        'chat_assistants',
        'chats',
        'plans',
        'user_subscriptions',
        'transactions',
        'user_payments',
        'settings',
        'pages',
        'faqs',
        'homepage_contents',
        'user_configs',
        'auto_responders',
    ];

    public function up(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('tenant_id')->nullable()->after('id');
                    $table->index('tenant_id');
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropIndex(['tenant_id']);
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
