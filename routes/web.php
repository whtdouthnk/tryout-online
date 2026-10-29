<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\{UjianController as GuruUjianController, SoalController, LaporanController};
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Siswa\UjianController as SiswaUjianController;
use Illuminate\Support\Facades\Route;

// ── Auth ───────────────────────────────────────────────────────────────────
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── REGISTER SISWA ─────────────────────────────────────────────────────────
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// ── GURU ───────────────────────────────────────────────────────────────────
Route::prefix('guru')->name('guru.')->middleware(['auth', 'role:guru'])->group(function () {

    Route::get('/dashboard', function () {
        $ujian = \App\Models\Ujian::where('guru_id', auth()->id())->withCount(['soal', 'peserta'])->latest()->get();
        return view('guru.dashboard', compact('ujian'));
        
    })->name('dashboard');
    

    // CRUD Ujian
    Route::resource('ujian', GuruUjianController::class);

    // Peserta Ujian
    Route::get('ujian/{ujian}/peserta',            [GuruUjianController::class, 'peserta'])->name('ujian.peserta');
    Route::post('ujian/{ujian}/peserta',           [GuruUjianController::class, 'tambahPeserta'])->name('ujian.peserta.tambah');
    Route::delete('ujian/{ujian}/peserta/{siswa}', [GuruUjianController::class, 'hapusPeserta'])->name('ujian.peserta.hapus');

    // Hasil Ujian
    Route::get('ujian/{ujian}/hasil', [GuruUjianController::class, 'hasil'])->name('ujian.hasil');

    // CRUD Soal
    Route::get('ujian/{ujian}/soal',            [SoalController::class, 'index'])->name('soal.index');
    Route::get('ujian/{ujian}/soal/create',     [SoalController::class, 'create'])->name('soal.create');
    Route::post('ujian/{ujian}/soal',           [SoalController::class, 'store'])->name('soal.store');
    Route::get('ujian/{ujian}/soal/{soal}/edit',[SoalController::class, 'edit'])->name('soal.edit');
    Route::put('ujian/{ujian}/soal/{soal}',     [SoalController::class, 'update'])->name('soal.update');
    Route::delete('ujian/{ujian}/soal/{soal}',  [SoalController::class, 'destroy'])->name('soal.destroy');

    // Laporan PDF
    Route::get('ujian/{ujian}/laporan/pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.pdf');
});

// ── SISWA ──────────────────────────────────────────────────────────────────
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {

    Route::get('/dashboard', function () {
        $ujian = \App\Models\PesertaUjian::where('siswa_id', auth()->id())->with('ujian')->get();
        return view('siswa.dashboard', compact('ujian'));
    })->name('dashboard');

    Route::get('ujian',                          [SiswaUjianController::class, 'index'])->name('ujian.index');
    Route::get('ujian/{ujian}/mulai',            [SiswaUjianController::class, 'mulai'])->name('ujian.mulai');
    Route::post('ujian/{ujian}/jawab',           [SiswaUjianController::class, 'simpanJawaban'])->name('ujian.jawab');
    Route::post('ujian/{ujian}/submit',          [SiswaUjianController::class, 'submit'])->name('ujian.submit');
    Route::get('hasil/{pesertaUjian}',           [SiswaUjianController::class, 'hasil'])->name('hasil');
});
