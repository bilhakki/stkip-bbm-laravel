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
        Schema::create('rooms', function (Blueprint $table) {
            $table->comment('Tabel ini berisi informasi tentang ruangan-ruangan yang digunakan untuk perkuliahan.');
            $table->id();
            $table->string('name')->comment('nama ruang bisa, diawali dengan nama gedung - lantai - nomor ruangan');
            $table->text('description')->nullable()->comment('berisi info lebih rinci mengenai lokasi ruangan dan rincian lainya');
            $table->integer('capacity')->comment('kapasitas maksimal mahasiswa dalam sebuah ruangan');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
