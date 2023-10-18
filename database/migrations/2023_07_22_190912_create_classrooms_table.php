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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->comment('menyimpan data tentang setiap kelas matakuliah yang ada di universitas. Setiap kelas akan memiliki informasi seperti nama kelas, tahun ajaran, semester, jumlah mahasiswa, dan lain sebagainya. tabel ini adalah panduan mahasiswa untuk memilik mata kuliah atau kelas yang akan diambil.');
            $table->id();
            $table->string('name')->comment('misalnya "Kelas A", "Kelas B", dst.');
            $table->integer('capacity')->comment('Kapasitas maksimum mahasiswa dalam kelas.');
            $table->integer('credits')->comment('menyimpan nilai jumlah kredit atau sks (sistem kredit semester) dari mata kuliah');
            
            $table->foreignId('season_id')->constrained('seasons')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
