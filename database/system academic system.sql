CREATE TABLE `academics` (
  `id` bigint(20) NOT NULL,
  `academicable_id` bigint(20) DEFAULT NULL,
  `academicable_type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `academic_advisors` (
  `id` bigint(20) NOT NULL,
  `lecturer_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL
);

CREATE TABLE `classrooms` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'misalnya "Kelas A", "Kelas B", dst.',
  `capacity` int(11) NOT NULL COMMENT 'Kapasitas maksimum mahasiswa dalam kelas.',
  `credits` int(11) NOT NULL COMMENT 'menyimpan nilai jumlah kredit atau sks (sistem kredit semester) dari mata kuliah',
  `season_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `classroom_enrollments` (
  `id` bigint(20) NOT NULL,
  `remarks` text DEFAULT NULL COMMENT 'Kolom ini digunakan untuk menyimpan catatan atau keterangan tambahan terkait status pendaftaran mahasiswa ke dalam kelas. Misalnya, alasan penolakan pendaftaran jika statusnya `rejected`, atau pesan persetujuan jika statusnya `approved`.',
  `status` ENUM ('pending', 'approved', 'rejected') NOT NULL COMMENT 'menyimpan status registrasi, seperti `pending` (menunggu persetujuan), `approved` (disetujui), atau `rejected` (ditolak).',
  `season_id` bigint(20) NOT NULL,
  `classroom_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `classroom_lecturer` (
  `id` bigint(20) NOT NULL,
  `classroom_id` bigint(20) NOT NULL,
  `lecturer_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL
);

CREATE TABLE `classroom_sessions` (
  `id` bigint(20) NOT NULL,
  `start_datetime` datetime NOT NULL COMMENT 'menyimpan tanggal dan jam dimulainya sesi kelas',
  `end_datetime` datetime NOT NULL COMMENT 'menyimpan tanggal dan jam berakhirnya sesi kelas',
  `attendance_code` varchar(255) DEFAULT NULL COMMENT 'menyimpan kode unik atau token yang digunakan mahasiswa untuk mencatat kehadiran secara otomatis atau online. Kode ini dapat dihasilkan secara acak untuk setiap sesi kelas.',
  `topic` text DEFAULT NULL COMMENT 'menyimpan topik atau materi yang akan dibahas dalam sesi tersebut.',
  `classroom_id` bigint(20) NOT NULL,
  `season_id` bigint(20) NOT NULL,
  `lecturer_id` bigint(20) NOT NULL,
  `room_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `classroom_student` (
  `id` bigint(20) NOT NULL,
  `classroom_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL
);

CREATE TABLE `courses` (
  `id` bigint(20) NOT NULL,
  `code` varchar(255) NOT NULL COMMENT 'menyimpan kode unik untuk mata kuliah',
  `name` varchar(255) NOT NULL COMMENT 'menyimpan nama lengkap mata kuliah',
  `credits` int(11) NOT NULL COMMENT 'menyimpan nilai default jumlah kredit atau sks (sistem kredit semester) dari mata kuliah',
  `major_id` bigint(20) NOT NULL,
  `faculty_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `course_prerequisites` (
  `id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `prerequisite_course_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `faculties` (
  `id` bigint(20) PRIMARY KEY NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'nama fakultas',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `failed_jobs` (
  `id` bigint(20) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT (current_timestamp())
);

CREATE TABLE `lecturers` (
  `id` bigint(20) NOT NULL,
  `position` varchar(255) DEFAULT NULL COMMENT 'menjelaskan dirinya dikampus, seperti asisten dosen, dosen atau dosen senior',
  `specialization` varchar(255) DEFAULT NULL COMMENT 'spesialisasi dari dosen ini',
  `phone_number` varchar(255) DEFAULT NULL COMMENT 'nomor telepon dosen',
  `status` ENUM ('active', 'inactive') DEFAULT NULL COMMENT 'status keaktifan dosen dalam sistem',
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `majors` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'nama jurusan',
  `faculty_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `migrations` (
  `id` int(10) PRIMARY KEY NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
);

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) PRIMARY KEY NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL
);

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp DEFAULT NULL,
  `expires_at` timestamp DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL
);

CREATE TABLE `rooms` (
  `id` bigint(20) PRIMARY KEY NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'nama ruang bisa, diawali dengan nama gedung - lantai - nomor ruangan',
  `description` text DEFAULT NULL COMMENT 'berisi info lebih rinci mengenai lokasi ruangan dan rincian lainya',
  `capacity` int(11) NOT NULL COMMENT 'kapasitas maksimal mahasiswa dalam sebuah ruangan',
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `seasons` (
  `id` bigint(20) PRIMARY KEY NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'misal: `2023/2024`, `2024/2025`, dst.',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
);

CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `student_id` varchar(255) NOT NULL COMMENT 'menyimpan nomor identifikasi mahasiswa seperti nomor induk mahasiswa',
  `current_credits` int(11) NOT NULL DEFAULT 0 COMMENT 'Untuk menghitung jumlah kredit atau sks yang telah diambil oleh setiap mahasiswa pada semester saat ini. Informasi ini diperlukan untuk memastikan bahwa setiap mahasiswa tidak mengambil lebih dari batas maksimum kredit yang diizinkan.',
  `admission_year` int(11) NOT NULL COMMENT 'menyimpan tahun masuk mahasiswa',
  `date_of_birth` date DEFAULT NULL COMMENT 'tanggal lahir mahasiswa',
  `gender` ENUM ('male', 'female', 'other') DEFAULT NULL COMMENT 'jenis kelamin mahasiswa',
  `status` ENUM ('active', 'inactive', 'graduate', 'dropout') DEFAULT NULL COMMENT 'status keaktifan mahasiswa dalam sistem',
  `address` text DEFAULT NULL COMMENT 'alamat mahasiswa',
  `phone_number` varchar(255) DEFAULT NULL COMMENT 'nomor telepon mahasiswa',
  `guardian_name` varchar(255) DEFAULT NULL COMMENT 'nama wali mahasiswa',
  `guardian_phone_number` varchar(255) DEFAULT NULL COMMENT 'nomor telepon wali mahasiswa',
  `blood_type` varchar(255) DEFAULT NULL COMMENT 'golongan darah mahasiswa',
  `tuition_fee` bigint(20) DEFAULT NULL COMMENT 'menyimpan besaran SPP untuk mahasiswa',
  `user_id` bigint(20) NOT NULL,
  `faculty_id` bigint(20) NOT NULL,
  `major_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `student_attendances` (
  `id` bigint(20) NOT NULL,
  `status` ENUM ('present', 'absent') NOT NULL COMMENT 'status kehadiran',
  `student_id` bigint(20) NOT NULL,
  `classroom_session_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `student_grades` (
  `id` bigint(20) NOT NULL,
  `grade` double(8,2) NOT NULL COMMENT 'menyimpan informasi tentang nilai yang diberikan pada mata kuliah tersebut.',
  `student_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `classroom_id` bigint(20) NOT NULL,
  `season_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `student_season_logs` (
  `id` bigint(20) NOT NULL,
  `status` ENUM ('active', 'inactive', 'graduate', 'dropout') NOT NULL COMMENT 'status mahasiswa dalam season tersebut, bisa berupa `active` untuk mahasiswa aktif, `inactive` untuk mahasiswa yang tidak aktif, `graduate` untuk mahasiswa yang telah lulus, dan `dropout` untuk mahasiswa yang telah drop out dari universitas',
  `description` text DEFAULT NULL COMMENT 'deskripsi atau catatan tambahan mengenai log kegiatan mahasiswa pada season tersebut',
  `student_id` bigint(20) NOT NULL,
  `season_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `tuition_payments` (
  `id` bigint(20) NOT NULL,
  `payment_at` datetime NOT NULL COMMENT 'menyimpan tanggal pembayaran SPP.',
  `amount` bigint(20) NOT NULL COMMENT 'menyimpan jumlah pembayaran SPP.',
  `receipt_number` varchar(255) DEFAULT NULL COMMENT 'menyimpan nomor kwitansi pembayaran.',
  `status` ENUM ('pending', 'paid', 'expired', 'failed') NOT NULL DEFAULT "pending" COMMENT 'status pembayaran.',
  `student_id` bigint(20) NOT NULL,
  `season_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'menyimpan nama pengguna',
  `email` varchar(255) NOT NULL COMMENT 'menyimpan alamat email pengguna yang unik',
  `username` varchar(255) NOT NULL COMMENT 'menyimpan nomor pengenal. Nomor Induk Mahasiswa untuk pelajar dan Nomor Identitas Pegawai untuk dosen dan pegawai akademik',
  `email_verified_at` timestamp DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp DEFAULT NULL,
  `role` ENUM ('admin', 'academic_university', 'academic_faculty', 'academic_major', 'lecturer', 'student') NOT NULL DEFAULT "student" COMMENT 'menunjukkan peran (admin, student, lecturer, academic_university, academic_faculty atau academic_major) dari pengguna',
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

ALTER TABLE `academics` COMMENT = 'Tabel ini menyimpan data pegawai akademik. Pegawai akademik dapat terdiri dari academic_university, academic_faculty atau academic_major.';

ALTER TABLE `academic_advisors` COMMENT = 'Mencatat hubungan antara dosen pembimbing akademik (academic advisor) dengan mahasiswa. Dosen pembimbing akademik adalah seorang dosen yang bertanggung jawab untuk memberikan bimbingan dan nasihat akademik kepada mahasiswa yang ditugaskan kepadanya. Setiap mahasiswa biasanya memiliki satu dosen pembimbing akademik yang membantu mereka dalam merencanakan kurikulum studi, memberikan saran mengenai mata kuliah yang harus diambil, membantu mengatasi masalah akademik, dan memberikan panduan umum untuk mencapai tujuan akademik.';

ALTER TABLE `classrooms` COMMENT = 'menyimpan data tentang setiap kelas matakuliah yang ada di universitas. Setiap kelas akan memiliki informasi seperti nama kelas, tahun ajaran, semester, jumlah mahasiswa, dan lain sebagainya. tabel ini adalah panduan mahasiswa untuk memilik mata kuliah atau kelas yang akan diambil.';

ALTER TABLE `classroom_enrollments` COMMENT = 'Tabel ini akan menghubungkan data mahasiswa dengan kelas yang mereka ambil pada setiap semester.';

ALTER TABLE `classroom_lecturer` COMMENT = 'table many to many yang menghubungkan table classroom dengan lecturer';

ALTER TABLE `classroom_sessions` COMMENT = 'mencatat detail mulai dari perencanaan kelas dari akademik di setiap sesi atau pertemuan dalam kelas. berisi tanggal, jam, ruangan dan deskripsi sesi kelas';

ALTER TABLE `classroom_student` COMMENT = 'table many to many yang menghubungkan table classroom dengan student';

ALTER TABLE `courses` COMMENT = 'Tabel ini berisi informasi tentang mata kuliah yang tersedia di sistem.';

ALTER TABLE `course_prerequisites` COMMENT = 'Tabel ini mencatat persyaratan prasyarat untuk setiap mata kuliah.';

ALTER TABLE `faculties` COMMENT = 'Tabel ini berisi informasi tentang fakultas-fakultas di universitas.';

ALTER TABLE `lecturers` COMMENT = 'Tabel ini berisi informasi tentang dosen-dosen di universitas.';

ALTER TABLE `majors` COMMENT = 'Tabel ini berisi informasi tentang jurusan-jurusan di universitas.';

ALTER TABLE `rooms` COMMENT = 'Tabel ini berisi informasi tentang ruangan-ruangan yang digunakan untuk perkuliahan.';

ALTER TABLE `students` COMMENT = 'Tabel ini menyimpan data mahasiswa';

ALTER TABLE `student_attendances` COMMENT = 'mencatat absensi mahasiswa pada setiap sesi kelas';

ALTER TABLE `student_grades` COMMENT = 'menyimpan nilai akademik mahasiswa pada setiap mata kuliah';

ALTER TABLE `student_season_logs` COMMENT = 'mencatat status mahasiswa per semester apakah aktif, cuti, lulus atau drop out';

ALTER TABLE `tuition_payments` COMMENT = 'table ini akan mencatat mahasiswa yang telah membayar spp';

ALTER TABLE `users` COMMENT = 'Tabel ini digunakan untuk menyimpan data pengguna atau user dalam sistem.';

ALTER TABLE `academics` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `academics` ADD FOREIGN KEY (`academicable_id`) REFERENCES `academics` (`id`) ON DELETE CASCADE;

ALTER TABLE `lecturers` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `majors` ADD FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE;

ALTER TABLE `students` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `students` ADD FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE;

ALTER TABLE `students` ADD FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`) ON DELETE CASCADE;

ALTER TABLE `courses` ADD FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE;

ALTER TABLE `courses` ADD FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`) ON DELETE CASCADE;

ALTER TABLE `course_prerequisites` ADD FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

ALTER TABLE `course_prerequisites` ADD FOREIGN KEY (`prerequisite_course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

ALTER TABLE `tuition_payments` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

ALTER TABLE `tuition_payments` ADD FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_season_logs` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_season_logs` ADD FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

ALTER TABLE `classrooms` ADD FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

ALTER TABLE `classrooms` ADD FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_enrollments` ADD FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_enrollments` ADD FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_enrollments` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_sessions` ADD FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_sessions` ADD FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_sessions` ADD FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_sessions` ADD FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_grades` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_grades` ADD FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_grades` ADD FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_grades` ADD FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_grades` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_attendances` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

ALTER TABLE `student_attendances` ADD FOREIGN KEY (`classroom_session_id`) REFERENCES `classroom_sessions` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_lecturer` ADD FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_lecturer` ADD FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_student` ADD FOREIGN KEY (`classroom_id`) REFERENCES `classrooms` (`id`) ON DELETE CASCADE;

ALTER TABLE `classroom_student` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

ALTER TABLE `academic_advisors` ADD FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

ALTER TABLE `academic_advisors` ADD FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE;

ALTER TABLE `sessions` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
