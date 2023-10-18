<?php

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
        Schema::create('classroom_sessions', function (Blueprint $table) {
            $table->comment('mencatat detail mulai dari perencanaan kelas dari akademik di setiap sesi atau pertemuan dalam kelas. berisi tanggal, jam, ruangan dan deskripsi sesi kelas');
            $table->id();
            $table->dateTime('start_datetime')->comment('menyimpan tanggal dan jam dimulainya sesi kelas');
            $table->dateTime('end_datetime')->comment('menyimpan tanggal dan jam berakhirnya sesi kelas');
            $table->string('attendance_code')->nullable()->comment('menyimpan kode unik atau token yang digunakan mahasiswa untuk mencatat kehadiran secara otomatis atau online. Kode ini dapat dihasilkan secara acak untuk setiap sesi kelas.');
            $table->text('topic')->nullable()->comment('menyimpan topik atau materi yang akan dibahas dalam sesi tersebut.');
            
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->foreignId('lecturer_id')->constrained('lecturers')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
        
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_sessions');
    }
};
