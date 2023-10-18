<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //
        ];
    }

    /*
      Schema::create('students', function (Blueprint $table) {
            $table->comment('Tabel ini menyimpan data mahasiswa');
            $table->id();
            $table->string('student_id')->comment('menyimpan nomor identifikasi mahasiswa seperti nomor induk mahasiswa');
            $table->integer('current_credits')->default(0)->comment('Untuk menghitung jumlah kredit atau sks yang telah diambil oleh setiap mahasiswa pada semester saat ini. Informasi ini diperlukan untuk memastikan bahwa setiap mahasiswa tidak mengambil lebih dari batas maksimum kredit yang diizinkan.');
            $table->integer('admission_year')->comment('menyimpan tahun masuk mahasiswa');
            $table->date('date_of_birth')->nullable()->comment('tanggal lahir mahasiswa');
            $table->enum('gender', [Gender::values()])->nullable()->comment('jenis kelamin mahasiswa');
            $table->enum('status', [StudentStatus::values()])->nullable()->comment('status keaktifan mahasiswa dalam sistem');
            $table->text('address')->nullable()->comment('alamat mahasiswa');
            $table->string('phone_number')->nullable()->comment('nomor telepon mahasiswa');
            $table->string('guardian_name')->nullable()->comment('nama wali mahasiswa');
            $table->string('guardian_phone_number')->nullable()->comment('nomor telepon wali mahasiswa');
            $table->string('blood_type')->nullable()->comment('golongan darah mahasiswa');
            $table->unsignedBigInteger('tuition_fee')->nullable()->comment('menyimpan besaran SPP untuk mahasiswa');
            
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade')->comment('merupakan foreign key yang mengacu pada tabel `users`, untuk menghubungkan data mahasiswa dengan data user');
            $table->foreignId('faculty_id')->constrained('faculties')->onDelete('cascade')->comment('menyimpan foreign key untuk menghubungkan data mahasiswa dengan fakultas');
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade')->comment('menyimpan foreign key untuk menghubungkan data mahasiswa dengan jurusan');

            $table->timestamps();
            $table->softDeletes();
        });
    */
}
