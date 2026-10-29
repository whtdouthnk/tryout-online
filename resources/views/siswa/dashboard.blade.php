@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('page_title', 'Dashboard Siswa')

@section('content')

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">
                            Total Ujian
                        </p>

                        <h3 class="fw-bold text-success mb-0">
                            {{ $ujian->count() }}
                        </h3>
                    </div>

                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-journal-check text-success fs-3"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">
                            Sedang Berlangsung
                        </p>

                        <h3 class="fw-bold text-warning mb-0">
                            {{ $ujian->where('status', 'berlangsung')->count() }}
                        </h3>
                    </div>

                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-clock-history text-warning fs-3"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">
                            Selesai
                        </p>

                        <h3 class="fw-bold text-primary mb-0">
                            {{ $ujian->where('status', 'selesai')->count() }}
                        </h3>
                    </div>

                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-check2-circle text-primary fs-3"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Daftar Ujian
                </h4>

                <p class="text-muted mb-0">
                    Selamat datang, {{ auth()->user()->name }}
                </p>
            </div>

            <span class="badge bg-success-subtle text-success px-3 py-2">
                Siswa
            </span>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th width="70">No</th>
                        <th>Judul Ujian</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($ujian as $item)

                    <tr>

                        <td class="fw-semibold">
                            {{ $loop->iteration }}
                        </td>

                        <td>

                            <div class="fw-semibold">
                                {{ $item->ujian->judul ?? '-' }}
                            </div>

                            <small class="text-muted">
                                {{ $item->ujian->mata_pelajaran ?? '-' }}
                            </small>

                        </td>

                        <td>

                            @if($item->status == 'selesai')

                                <span class="badge bg-success">
                                    Selesai
                                </span>

                            @elseif($item->status == 'berlangsung')

                                <span class="badge bg-warning text-dark">
                                    Berlangsung
                                </span>

                            @else

                                <span class="badge bg-primary">
                                    Belum Mulai
                                </span>

                            @endif

                        </td>

                        <td>

                            @if($item->status != 'selesai')

                                <a href="{{ route('siswa.ujian.mulai', $item->ujian_id) }}"
                                   class="btn btn-success btn-sm">

                                    <i class="bi bi-play-fill"></i>
                                    Kerjakan

                                </a>

                            @else

                                <a href="{{ route('siswa.hasil', $item->id) }}"
                                   class="btn btn-primary btn-sm">

                                    <i class="bi bi-bar-chart-fill"></i>
                                    Lihat Hasil

                                </a>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center py-5">

                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png"
                                 width="120"
                                 class="mb-3 opacity-75">

                            <h5 class="fw-bold text-muted">
                                Belum Ada Ujian
                            </h5>

                            <p class="text-muted mb-0">
                                Guru belum menambahkan ujian untuk kamu.
                            </p>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection