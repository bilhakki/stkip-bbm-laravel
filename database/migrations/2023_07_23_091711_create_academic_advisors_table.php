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
        Schema::create('academic_advisors', function (Blueprint $table) {
            $table->comment('Mencatat hubungan antara dosen pembimbing akademik (academic advisor) dengan mahasiswa. Dosen pembimbing akademik adalah seorang dosen yang bertanggung jawab untuk memberikan bimbingan dan nasihat akademik kepada mahasiswa yang ditugaskan kepadanya. Setiap mahasiswa biasanya memiliki satu dosen pembimbing akademik yang membantu mereka dalam merencanakan kurikulum studi, memberikan saran mengenai mata kuliah yang harus diambil, membantu mengatasi masalah akademik, dan memberikan panduan umum untuk mencapai tujuan akademik.');
            $table->id();
            $table->foreignId('lecturer_id')->constrained('lecturers')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_advisors');
    }
};
