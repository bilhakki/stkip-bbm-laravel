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
        Schema::create('student_grades', function (Blueprint $table) {
            $table->comment('menyimpan nilai akademik mahasiswa pada setiap mata kuliah');
            $table->id();
            
            $table->float('grade')->comment('menyimpan informasi tentang nilai yang diberikan pada mata kuliah tersebut.');
        
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade')->comment('foreign key yang mengacu pada tabel `students`, untuk menghubungkan nilai dengan mahasiswa tertentu');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade')->comment('untuk menghubungkan nilai dengan mata kuliah tertentu');
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade')->comment('untuk mengetahui siapa yang menginput nilai, bisa jadi admin, akademik atau dosen');
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade')->comment('untuk menghubungkan nilai dengan semester tertentu');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('untuk mengetahui siapa yang menginput nilai, bisa jadi admin, akademik atau dosen');
        
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
