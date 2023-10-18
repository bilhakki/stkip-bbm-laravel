<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Major;

class CourseSeeder extends Seeder
{
    public function run()
    {
    }
}

/*
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
*/
