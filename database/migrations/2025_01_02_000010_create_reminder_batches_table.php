<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->enum('status', ['draft', 'pending_approval', 'approved', 'scheduled', 'processing', 'done', 'rejected'])->default('draft');
            $table->integer('total_items')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->integer('skipped_count')->default(0);
            $table->text('filter_description')->nullable();
            $table->text('reject_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_batches');
    }
};
