<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';

    protected $fillable = [
        'ujian_id', 'pertanyaan', 'gambar',
        'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d',
        'jawaban_benar', 'pembahasan', 'poin', 'urutan',
    ];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswa::class);
    }
}
