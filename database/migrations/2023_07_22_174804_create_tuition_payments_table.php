<?php

use App\Enums\TuitionPaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tuition_payments', function (Blueprint $table) {
            $table->comment('table ini akan mencatat mahasiswa yang telah membayar spp');
            $table->id();
            $table->dateTime('payment_at')->comment('menyimpan tanggal pembayaran SPP.');
            $table->unsignedBigInteger('amount')->comment('menyimpan jumlah pembayaran SPP.');
            $table->string('receipt_number')->nullable()->comment('menyimpan nomor kwitansi pembayaran.');
            $table->enum('status', [TuitionPaymentStatus::values()])->default('pending')->comment('status pembayaran.');
            
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuition_payments');
    }
};
