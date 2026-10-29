@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('page_title', 'Dashboard Guru')

@section('content')

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">

                <div>
                    <p class="text-muted mb-1">Total Ujian</p>
                    <h2 class="fw-bold text-success mb-0">
                        {{ $ujian->count() }}
                    </h2>
                </div>

                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-journal-check text-success fs-3"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">

                <div>
                    <p class="text-muted mb-1">Total Soal</p>
                    <h2 class="fw-bold text-primary mb-0">
                        {{ $ujian->sum('soal_count') }}
                    </h2>
                </div>

                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-file-earmark-text text-primary fs-3"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between">

                <div>
                    <p class="text-muted mb-1">Total Peserta</p>
                    <h2 class="fw-bold text-warning mb-0">
                        {{ $ujian->sum('peserta_count') }}
                    </h2>
                </div>

                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-people text-warning fs-3"></i>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">Data Ujian</h4>
                <p class="text-muted mb-0">
                    Kelola semua data ujian dengan mudah
                </p>
            </div>

            <a href="{{ route('guru.ujian.create') }}"
               class="btn btn-success rounded-pill px-4">

                <i class="bi bi-plus-circle me-1"></i>
                Tambah Ujian

            </a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-success">

                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Mata Pelajaran</th>
                        <th>Jumlah Soal</th>
                        <th>Peserta</th>
                        <th>Status</th>
                        <th width="300">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($ujian as $key => $u)

                    <tr>

                        <td class="fw-semibold">
                            {{ $key + 1 }}
                        </td>

                        <td>

                            <div class="fw-semibold">
                                {{ $u->judul }}
                            </div>

                            <small class="text-muted">
                                {{ $u->durasi_menit }} menit
                            </small>

                        </td>

                        <td>
                            {{ $u->mata_pelajaran }}
                        </td>

                        <td>
                            <span class="badge bg-primary">
                                {{ $u->soal_count }} Soal
                            </span>
                        </td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $u->peserta_count }} Peserta
                            </span>
                        </td>

                        <td>

                            @if($u->status == 'aktif')

                                <span class="badge bg-success">
                                    Aktif
                                </span>

                            @elseif($u->status == 'draft')

                                <span class="badge bg-warning text-dark">
                                    Draft
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Selesai
                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="d-flex flex-wrap gap-2">

                                <a href="{{ route('guru.soal.index', $u->id) }}"
                                   class="btn btn-sm btn-outline-primary rounded-pill">

                                    <i class="bi bi-list-check"></i>
                                    Soal

                                </a>

                                <a href="{{ route('guru.ujian.edit', $u->id) }}"
                                   class="btn btn-sm btn-outline-success rounded-pill">

                                    <i class="bi bi-pencil-square"></i>
                                    Edit

                                </a>

                                <a href="{{ route('guru.ujian.peserta', $u->id) }}"
                                   class="btn btn-sm btn-outline-warning rounded-pill">

                                    <i class="bi bi-people"></i>
                                    Peserta

                                </a>

                                <a href="{{ route('guru.ujian.hasil', $u->id) }}"
                                   class="btn btn-sm btn-outline-dark rounded-pill">

                                    <i class="bi bi-bar-chart"></i>
                                    Hasil

                                </a>
                                <a href="{{ route('guru.laporan.pdf', $u->id) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-danger rounded-pill">
                                     <i class="bi bi-file-pdf"></i> Cetak PDF
                                 </a>

                                <form action="{{ route('guru.ujian.destroy', $u->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus ujian ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger rounded-pill">

                                        <i class="bi bi-trash"></i>
                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center py-5">

                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png"
                                 width="120"
                                 class="mb-3 opacity-75">

                            <h5 class="fw-semibold">
                                Belum Ada Ujian
                            </h5>

                            <p class="text-muted">
                                Silakan buat ujian baru terlebih dahulu
                            </p>

                            <a href="{{ route('guru.ujian.create') }}"
                               class="btn btn-success rounded-pill px-4">

                                <i class="bi bi-plus-circle me-1"></i>
                                Tambah Ujian

                            </a>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection