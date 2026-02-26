<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->enum('status', [
                'dimiliki',
                'lapor_jual',
                'rusak_berat',
                'hilang',
                'kecelakaan',
                'alamat_tidak_jelas',
                'pindah_alamat',
                'rumah_kosong',
                'lainnya',
            ]);
            $table->date('status_date');
            $table->text('notes')->nullable();
            $table->foreignId('reported_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();

            $table->index(['task_id', 'status_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_statuses');
    }
};
