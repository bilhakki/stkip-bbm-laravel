<?php

use App\Enums\StudentAttendanceStatus;
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
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->comment('mencatat absensi mahasiswa pada setiap sesi kelas');
            $table->id();
        
            $table->enum('status', [StudentAttendanceStatus::values()])->comment('status kehadiran');
        
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade')->comment('untuk menghubungkan mahasiswa yang melakukan absen');
            $table->foreignId('classroom_session_id')->constrained('classroom_sessions')->onDelete('cascade')->comment('untuk menghubungkan sesi kelas tertentu dengan absen');
        
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
