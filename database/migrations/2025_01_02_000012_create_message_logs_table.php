<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_item_id')->nullable()->constrained()->nullOnDelete();
            $table->string('provider')->nullable();
            $table->string('provider_message_id')->nullable()->index();
            $table->string('phone')->nullable();
            $table->text('message_body')->nullable();
            $table->enum('status', ['queued', 'sent', 'delivered', 'read', 'failed'])->default('queued');
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_logs');
    }
};
