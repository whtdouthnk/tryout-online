@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Tambah Peserta</h3>
            <small class="text-muted">{{ $ujian->judul }}</small>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('guru.ujian.peserta.tambah', $ujian->id) }}"
                  method="POST">

                @csrf

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-success">
                            <tr>
                                <th style="width:60px;">Pilih</th>
                                <th>Nama</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($semuaSiswa as $siswa)
                                <tr>

                                    <td class="text-center">
                                        <input type="checkbox"
                                               name="siswa_ids[]"
                                               value="{{ $siswa->id }}"
                                               class="form-check-input"

                                               @if(in_array($siswa->id, $pesertaSudahAda))
                                                   checked
                                               @endif
                                        >
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $siswa->name }}
                                    </td>

                                    <td>
                                        {{ $siswa->nis }}
                                    </td>

                                    <td>
                                        {{ $siswa->kelas }}
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('guru.ujian.index') }}"
                       class="btn btn-outline-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-success px-4">
                        Simpan Peserta
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection