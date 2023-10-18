<?php

use App\Enums\ClassroomEnrollmentStatus;
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
        Schema::create('classroom_enrollments', function (Blueprint $table) {
            $table->comment('Tabel ini akan menghubungkan data mahasiswa dengan kelas yang mereka ambil pada setiap semester.');
            $table->id();
            $table->text('remarks')->nullable()->comment('Kolom ini digunakan untuk menyimpan catatan atau keterangan tambahan terkait status pendaftaran mahasiswa ke dalam kelas. Misalnya, alasan penolakan pendaftaran jika statusnya `rejected`, atau pesan persetujuan jika statusnya `approved`.');
            $table->enum('status', [ClassroomEnrollmentStatus::values()])->comment('menyimpan status registrasi, seperti `pending` (menunggu persetujuan), `approved` (disetujui), atau `rejected` (ditolak).');
        
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_enrollments');
    }
};
