@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Daftar Soal</h3>
            <small class="text-muted">{{ $ujian->judul }}</small>
        </div>

        <a href="{{ route('guru.soal.create', $ujian->id) }}"
           class="btn btn-success">
            + Tambah Soal
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-success">
                        <tr>
                            <th width="60">No</th>
                            <th>Pertanyaan</th>
                            <th width="120">Jawaban Benar</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($soal as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $item->pertanyaan }}
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-success">
                                    {{ $item->jawaban_benar }}
                                </span>
                            </td>

                            <td class="d-flex gap-2">

                                <a href="{{ route('guru.soal.edit', [$ujian->id, $item->id]) }}"
                                   class="btn btn-sm btn-warning text-white">
                                    Edit
                                </a>

                                <form action="{{ route('guru.soal.destroy', [$ujian->id, $item->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus soal?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>

                                </form>

                            </td>
                        </tr>
                        @empty

                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Belum ada soal
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection