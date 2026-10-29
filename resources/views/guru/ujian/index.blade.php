@extends('layouts.app')

@section('title', 'Data Ujian')
@section('page_title', 'Data Ujian')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">
                    Data Ujian
                </h3>

                <p class="text-muted mb-0">
                    Kelola semua ujian yang telah dibuat
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
                        <th>Judul Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th width="280">Aksi</th>
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
                                Dibuat:
                                {{ $u->created_at->format('d M Y') }}
                            </small>

                        </td>

                        <td>
                            {{ $u->mata_pelajaran }}
                        </td>

                        <td>

                            <span class="badge bg-primary">
                                {{ $u->durasi_menit }} Menit
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

                        <td colspan="6" class="text-center py-5">

                            <div class="mb-3">

                                <i class="bi bi-journal-x text-muted"
                                   style="font-size: 70px"></i>

                            </div>

                            <h5 class="fw-semibold">
                                Belum Ada Ujian
                            </h5>

                            <p class="text-muted">
                                Silakan tambahkan ujian baru terlebih dahulu
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