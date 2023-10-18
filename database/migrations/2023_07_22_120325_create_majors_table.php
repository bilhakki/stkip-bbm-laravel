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
        Schema::create('majors', function (Blueprint $table) {
            $table->comment('Tabel ini berisi informasi tentang jurusan-jurusan di universitas.');
            $table->id();
            $table->string('name')->comment('nama jurusan');
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade')->comment('menghubungkan jurusan dengan fakultas dimana 1 fakultas bisa terdapat 1 atau banyak jurusan');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
