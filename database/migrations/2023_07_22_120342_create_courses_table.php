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
        Schema::create('courses', function (Blueprint $table) {
            $table->comment('Tabel ini berisi informasi tentang mata kuliah yang tersedia di sistem.');
            $table->id();
            $table->string('code')->comment('menyimpan kode unik untuk mata kuliah');
            $table->string('name')->comment('menyimpan nama lengkap mata kuliah');
            $table->integer('credits')->comment('menyimpan nilai default jumlah kredit atau sks (sistem kredit semester) dari mata kuliah');
            
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade')->comment('menyimpan foreign key untuk menghubungkan data mahasiswa dengan jurusan');
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade')->comment('menyimpan foreign key untuk menghubungkan data mahasiswa dengan fakultas');
            
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
