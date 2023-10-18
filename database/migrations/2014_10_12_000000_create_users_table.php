<?php

use App\Enums\UserRole;
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
        Schema::create('users', function (Blueprint $table) {
            $table->comment('Tabel ini digunakan untuk menyimpan data pengguna atau user dalam sistem.');
            $table->id();
            $table->string('name')->comment('menyimpan nama pengguna');
            $table->string('email')->unique()->comment('menyimpan alamat email pengguna yang unik');
            $table->string('username')->unique()->comment('menyimpan nomor pengenal. Nomor Induk Mahasiswa untuk pelajar dan Nomor Identitas Pegawai untuk dosen dan pegawai akademik');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', [UserRole::values()])->default('student')->comment('menunjukkan peran (admin, student, lecturer, academic_university, academic_faculty atau academic_major) dari pengguna');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
