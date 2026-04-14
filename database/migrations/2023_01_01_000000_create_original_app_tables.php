<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates all original HeyChatMate tables that existed in the base app
 * but had no Laravel migrations. These must run BEFORE the tenant
 * migrations that add tenant_id columns.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. Settings (key-value store)
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key');
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        // 2. Plans (subscription plans for end users)
        if (!Schema::hasTable('plans')) {
            Schema::create('plans', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('type')->default('month'); // month, year, credit
                $table->string('api_type')->nullable();
                $table->integer('max_bots')->default(1);
                $table->decimal('price', 10, 2)->default(0);
                $table->integer('credits')->default(0);
                $table->text('features')->nullable();
                $table->string('subtitle')->nullable();
                $table->boolean('status')->default(1);
            });
        }

        // 3. Chat Assistants (bots)
        if (!Schema::hasTable('chat_assistants')) {
            Schema::create('chat_assistants', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('avatar')->nullable();
                $table->string('page_title')->nullable();
                $table->string('chat_title')->nullable();
                $table->string('form_title')->nullable();
                $table->string('floating_text')->nullable();
                $table->text('first_reply')->nullable();
                $table->string('chat_color')->default('#666EE8');
                $table->string('chat_icon')->default('default');
                $table->boolean('type_effect')->default(1);
                $table->boolean('phone_field')->default(0);
                $table->string('allowed_domain')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 4. Chats (chat sessions)
        if (!Schema::hasTable('chats')) {
            Schema::create('chats', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('chat_assistant_id');
                $table->string('identifier')->unique();
                $table->string('user_ip')->nullable();
                $table->text('user_agent')->nullable();
                $table->string('reff_site')->nullable();
                $table->text('ip_details')->nullable();
                $table->text('customer_data')->nullable();
                $table->string('customer_name')->nullable();
                $table->string('customer_email')->nullable();
                $table->string('customer_phone')->nullable();
                $table->boolean('status')->default(0);
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('chat_assistant_id')->references('id')->on('chat_assistants')->onDelete('cascade');
            });
        }

        // 5. Conversations (individual messages within a chat)
        if (!Schema::hasTable('conversations')) {
            Schema::create('conversations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('chat_id');
                $table->string('role'); // user, assistant
                $table->text('content');
                $table->string('ip')->nullable();
                $table->unsignedBigInteger('answer_for')->nullable();
                $table->timestamps();

                $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
            });
        }

        // 6. AI Instructions (training content per assistant)
        if (!Schema::hasTable('ai_instructions')) {
            Schema::create('ai_instructions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('chat_assistant_id');
                $table->unsignedBigInteger('user_id');
                $table->longText('content');
                $table->integer('character_count')->default(0);
                $table->timestamps();

                $table->foreign('chat_assistant_id')->references('id')->on('chat_assistants')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 7. Train Data
        if (!Schema::hasTable('train_datas')) {
            Schema::create('train_datas', function (Blueprint $table) {
                $table->id();
                $table->text('prompt');
                $table->text('completation')->nullable();
                $table->timestamps();
            });
        }

        // 8. Form Fields (custom form fields per assistant)
        if (!Schema::hasTable('form_fields')) {
            Schema::create('form_fields', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('chat_assistant_id');
                $table->unsignedBigInteger('user_id');
                $table->string('type')->default('text');
                $table->string('label');
                $table->string('name');
                $table->boolean('required')->default(0);
                $table->timestamps();

                $table->foreign('chat_assistant_id')->references('id')->on('chat_assistants')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 9. Payment Gateways
        if (!Schema::hasTable('payment_gateways')) {
            Schema::create('payment_gateways', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('keyword')->nullable();
                $table->text('information')->nullable(); // JSON config
                $table->boolean('status')->default(1);
            });
        }

        // 10. Transactions
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('trx_id');
                $table->unsignedBigInteger('plan_id')->nullable();
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('type', 5)->default('+'); // + or -
                $table->string('remark')->nullable(); // credit, debit
                $table->boolean('status')->default(1);
                $table->string('details')->nullable();
                $table->string('credits')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 11. User Subscriptions
        if (!Schema::hasTable('user_subscriptions')) {
            Schema::create('user_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('plan_id');
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('cycle')->default('month'); // month, year
                $table->dateTime('due_date')->nullable();
                $table->boolean('status')->default(1);
                $table->integer('payment_method')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            });
        }

        // 12. User Payments
        if (!Schema::hasTable('user_payments')) {
            Schema::create('user_payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('plan_id');
                $table->unsignedBigInteger('payment_gateway_id')->nullable();
                $table->decimal('amount', 10, 2)->default(0);
                $table->string('status')->default('pending');
                $table->text('payment_data')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            });
        }

        // 13. User Configs (API keys per user)
        if (!Schema::hasTable('user_configs')) {
            Schema::create('user_configs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('api_key')->nullable();
                $table->string('ai_model')->default('gpt-3.5-turbo');

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 14. Auto Responders
        if (!Schema::hasTable('auto_responders')) {
            Schema::create('auto_responders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->boolean('getresponse_status')->default(0);
                $table->string('getresponse_campaign_id')->nullable();
                $table->string('getresponse_token')->nullable();
                $table->boolean('sendlane_status')->default(0);
                $table->string('sendlane_apiKey')->nullable();
                $table->string('sendlane_apiHash')->nullable();
                $table->string('sendlane_listid')->nullable();
                $table->boolean('systemio_status')->default(0);
                $table->string('systemio_apikey')->nullable();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 15. Pages (CMS pages)
        if (!Schema::hasTable('pages')) {
            Schema::create('pages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('title');
                $table->string('slug')->unique();
                $table->longText('contents')->nullable();
                $table->integer('menu_order')->nullable();
                $table->boolean('footer_link')->default(0);
                $table->boolean('header_link')->default(0);
            });
        }

        // 16. FAQs
        if (!Schema::hasTable('faqs')) {
            Schema::create('faqs', function (Blueprint $table) {
                $table->id();
                $table->text('question');
                $table->longText('answer');
            });
        }

        // 17. Homepage Contents
        if (!Schema::hasTable('homepage_contents')) {
            Schema::create('homepage_contents', function (Blueprint $table) {
                $table->id();
                $table->string('type'); // why, how, testimonials
                $table->string('title');
                $table->text('text')->nullable();
                $table->string('icon')->nullable();
                $table->string('image')->nullable();
            });
        }

        // 18. Countries
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code', 10)->nullable();
            });
        }

        // 19. Social Providers (OAuth)
        if (!Schema::hasTable('social_providers')) {
            Schema::create('social_providers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('provider_id');
                $table->string('provider'); // google, github, etc.
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        // 20. Subscribers
        if (!Schema::hasTable('subscribers')) {
            Schema::create('subscribers', function (Blueprint $table) {
                $table->id();
                $table->string('email');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Drop in reverse order to respect foreign key constraints
        $tables = [
            'subscribers', 'social_providers', 'countries', 'homepage_contents',
            'faqs', 'pages', 'auto_responders', 'user_configs', 'user_payments',
            'user_subscriptions', 'transactions', 'payment_gateways', 'form_fields',
            'train_datas', 'ai_instructions', 'conversations', 'chats',
            'chat_assistants', 'plans', 'settings',
        ];

        foreach ($tables as $tableName) {
            Schema::dropIfExists($tableName);
        }
    }
};
