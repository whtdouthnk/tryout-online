<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Peserta ujian (siswa yang diizinkan mengikuti ujian tertentu)
        Schema::create('peserta_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained('ujian')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('mulai_at')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->enum('status', ['belum', 'berlangsung', 'selesai'])->default('belum');
            $table->timestamps();
            $table->unique(['ujian_id', 'siswa_id']);
        });

        // Jawaban per soal per siswa
        Schema::create('jawaban_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_ujian_id')->constrained('peserta_ujian')->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('soal')->onDelete('cascade');
            $table->char('jawaban', 1)->nullable()->comment('A/B/C/D atau null jika tidak dijawab');
            $table->boolean('is_correct')->default(false);
            $table->integer('poin_diperoleh')->default(0);
            $table->timestamps();
            $table->unique(['peserta_ujian_id', 'soal_id']);
        });

        // Hasil final ujian per siswa
        Schema::create('hasil_ujian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_ujian_id')->constrained('peserta_ujian')->onDelete('cascade')->unique();
            $table->integer('total_benar')->default(0);
            $table->integer('total_salah')->default(0);
            $table->integer('total_kosong')->default(0);
            $table->decimal('nilai', 5, 2)->default(0);
            $table->integer('durasi_pengerjaan')->nullable()->comment('dalam detik');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_ujian');
        Schema::dropIfExists('jawaban_siswa');
        Schema::dropIfExists('peserta_ujian');
    }
};
