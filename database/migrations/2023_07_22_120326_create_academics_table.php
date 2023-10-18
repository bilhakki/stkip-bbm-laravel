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
        Schema::create('academics', function (Blueprint $table) {
            $table->comment('Tabel ini menyimpan data pegawai akademik. Pegawai akademik dapat terdiri dari academic_university, academic_faculty atau academic_major.');
            
            $table->id();

            $table->unsignedBigInteger('academicable_id')->nullable();
            $table->string('academicable_type')->nullable();
            // $table->morphs('academicable');

            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade')->comment('merupakan foreign key yang mengacu pada tabel `users`, untuk menghubungkan data pegawai akademik dengan data user');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academics');
    }
};
