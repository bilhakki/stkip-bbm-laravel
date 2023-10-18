<?php

use App\Enums\StudentStatus;
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
        Schema::create('student_season_logs', function (Blueprint $table) {
            $table->comment('mencatat status mahasiswa per semester apakah aktif, cuti, lulus atau drop out');
            $table->id();
            $table->enum('status', [StudentStatus::values()])->comment('status mahasiswa dalam season tersebut, bisa berupa `active` untuk mahasiswa aktif, `inactive` untuk mahasiswa yang tidak aktif, `graduate` untuk mahasiswa yang telah lulus, dan `dropout` untuk mahasiswa yang telah drop out dari universitas');
            $table->text('description')->nullable()->comment('deskripsi atau catatan tambahan mengenai log kegiatan mahasiswa pada season tersebut');
            
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
        Schema::dropIfExists('student_season_logs');
    }
};
