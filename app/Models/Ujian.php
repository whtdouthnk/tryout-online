<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $table = 'ujian';

    protected $fillable = [
        'guru_id', 'judul', 'deskripsi', 'mata_pelajaran',
        'durasi_menit', 'jumlah_soal', 'tanggal_mulai',
        'tanggal_selesai', 'status', 'acak_soal', 'acak_jawaban',
    ];

    protected $casts = [
        'tanggal_mulai'  => 'datetime',
        'tanggal_selesai' => 'datetime',
        'acak_soal'      => 'boolean',
        'acak_jawaban'   => 'boolean',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

    public function peserta()
    {
        return $this->hasMany(PesertaUjian::class);
    }

    public function siswa()
    {
        return $this->belongsToMany(User::class, 'peserta_ujian', 'ujian_id', 'siswa_id')
                    ->withPivot('status', 'mulai_at', 'selesai_at');
    }
}
