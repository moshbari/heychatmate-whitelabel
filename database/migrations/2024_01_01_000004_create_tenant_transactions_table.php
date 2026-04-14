<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id')->unique();
            $table->unsignedBigInteger('tenant_id');
            $table->decimal('amount', 10, 2);
            $table->integer('credits')->default(0);
            $table->enum('type', ['+', '-']);
            $table->string('remark'); // credit_purchase, usage_deduction, plan_allocation
            $table->text('details')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_transactions');
    }
};
