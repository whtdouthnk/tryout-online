@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Hasil Ujian</h3>
            <small class="text-muted">{{ $ujian->judul }}</small>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Nilai</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($hasil as $index => $p)
                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $p->siswa->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $p->siswa->nis ?? '-' }}
                                </td>

                                <td>
                                    {{ $p->siswa->kelas ?? '-' }}
                                </td>

                                <td>
                                    <span class="badge bg-primary fs-6">
                                        {{ $p->hasil->nilai ?? 0 }}
                                    </span>
                                </td>

                                <td>
                                    @if($p->hasil)
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum</span>
                                    @endif
                                </td>

                            </tr>
                        @empty

                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada peserta atau hasil ujian
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-end mt-4">

                <a href="{{ route('guru.ujian.index') }}"
                   class="btn btn-outline-secondary">
                    Kembali
                </a>

            </div>

        </div>
    </div>

</div>

@endsection