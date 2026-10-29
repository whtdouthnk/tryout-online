<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'nis', 'kelas'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    // Relasi guru → ujian yang dibuat
    public function ujianDibuat()
    {
        return $this->hasMany(Ujian::class, 'guru_id');
    }

    // Relasi siswa → ujian yang diikuti
    public function pesertaUjian()
    {
        return $this->hasMany(PesertaUjian::class, 'siswa_id');
    }
}
