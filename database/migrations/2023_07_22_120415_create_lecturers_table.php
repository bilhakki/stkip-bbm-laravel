<?php

use App\Enums\LecturerStatus;
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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->comment('Tabel ini berisi informasi tentang dosen-dosen di universitas.');
            $table->id();
            $table->string('position')->nullable()->comment('menjelaskan dirinya dikampus, seperti asisten dosen, dosen atau dosen senior');
            $table->string('specialization')->nullable()->comment('spesialisasi dari dosen ini');
            $table->string('phone_number')->nullable()->comment('nomor telepon dosen');
            $table->enum('status', [LecturerStatus::values()])->nullable()->comment('status keaktifan dosen dalam sistem');
        
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
            $table->timestamps();
            $table->softDeletes();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
