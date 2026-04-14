<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ai_models')) {
            Schema::create('ai_models', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('api_code');
                $table->boolean('status')->default(1);
            });

            // Seed default AI models
            DB::table('ai_models')->insert([
                ['name' => 'GPT-3.5 Turbo', 'api_code' => 'gpt-3.5-turbo', 'status' => 1],
                ['name' => 'GPT-3.5 Turbo 16K', 'api_code' => 'gpt-3.5-turbo-16k', 'status' => 1],
                ['name' => 'GPT-4', 'api_code' => 'gpt-4', 'status' => 1],
                ['name' => 'GPT-4 Turbo', 'api_code' => 'gpt-4-turbo', 'status' => 1],
                ['name' => 'GPT-4o', 'api_code' => 'gpt-4o', 'status' => 1],
                ['name' => 'GPT-4o Mini', 'api_code' => 'gpt-4o-mini', 'status' => 1],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_models');
    }
};
