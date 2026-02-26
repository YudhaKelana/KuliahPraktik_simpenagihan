<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_batch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reminder_rule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('taxpayer_id')->constrained()->cascadeOnDelete();
            $table->timestamp('planned_send_at')->nullable();
            $table->enum('status', ['pending', 'queued', 'sent', 'delivered', 'failed', 'skipped'])->default('pending');
            $table->string('skip_reason')->nullable();
            $table->timestamps();

            $table->unique(
                ['vehicle_id', 'reminder_rule_id', 'planned_send_at'],
                'reminder_items_vehicle_rule_date_unique'
            );
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_items');
    }
};
