<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaUjian extends Model
{
    protected $table = 'peserta_ujian';

    protected $fillable = ['ujian_id', 'siswa_id', 'mulai_at', 'selesai_at', 'status'];

    protected $casts = [
        'mulai_at'   => 'datetime',
        'selesai_at' => 'datetime',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanSiswa::class);
    }

    public function hasil()
    {
        return $this->hasOne(HasilUjian::class);
    }

    public function getSisaWaktuAttribute(): int
    {
        if (!$this->mulai_at) return 0;
        $batasSelesai = $this->mulai_at->addMinutes($this->ujian->durasi_menit);
        return max(0, now()->diffInSeconds($batasSelesai, false));
    }
}

class JawabanSiswa extends Model
{
    protected $table = 'jawaban_siswa';

    protected $fillable = ['peserta_ujian_id', 'soal_id', 'jawaban', 'is_correct', 'poin_diperoleh'];

    protected $casts = ['is_correct' => 'boolean'];

    public function pesertaUjian()
    {
        return $this->belongsTo(PesertaUjian::class);
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}

class HasilUjian extends Model
{
    protected $table = 'hasil_ujian';

    protected $fillable = [
        'peserta_ujian_id', 'total_benar', 'total_salah',
        'total_kosong', 'nilai', 'durasi_pengerjaan', 'submitted_at',
    ];

    protected $casts = ['submitted_at' => 'datetime'];

    public function pesertaUjian()
    {
        return $this->belongsTo(PesertaUjian::class);
    }
}
