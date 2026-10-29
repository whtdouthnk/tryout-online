@extends('layouts.app')

@section('title', 'Hasil Ujian')
@section('page_title', 'Hasil Ujian')

@section('content')

<div class="row g-4 mb-4">

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <p class="text-muted mb-1">
                    Nilai
                </p>

                <h2 class="fw-bold text-success mb-0">
                    {{ $pesertaUjian->hasil->nilai ?? 0 }}
                </h2>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <p class="text-muted mb-1">
                    Jawaban Benar
                </p>

                <h2 class="fw-bold text-primary mb-0">
                    {{ $pesertaUjian->hasil->total_benar ?? 0 }}
                </h2>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <p class="text-muted mb-1">
                    Jawaban Salah
                </p>

                <h2 class="fw-bold text-danger mb-0">
                    {{ $pesertaUjian->hasil->total_salah ?? 0 }}
                </h2>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">

                <p class="text-muted mb-1">
                    Tidak Dijawab
                </p>

                <h2 class="fw-bold text-warning mb-0">
                    {{ $pesertaUjian->hasil->total_kosong ?? 0 }}
                </h2>

            </div>
        </div>

    </div>

</div>

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold mb-1">
                    {{ $pesertaUjian->ujian->judul }}
                </h3>

                <p class="text-muted mb-0">
                    Hasil pengerjaan ujian siswa
                </p>

            </div>

            <span class="badge bg-success px-3 py-2">
                Selesai
            </span>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <tbody>

                    <tr>
                        <th width="250">Nama Siswa</th>
                        <td>{{ auth()->user()->name }}</td>
                    </tr>

                    <tr>
                        <th>Mata Pelajaran</th>
                        <td>{{ $pesertaUjian->ujian->mata_pelajaran }}</td>
                    </tr>

                    <tr>
                        <th>Nilai</th>
                        <td>
                            <span class="badge bg-success">
                                {{ $pesertaUjian->hasil->nilai ?? 0 }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Total Benar</th>
                        <td>{{ $pesertaUjian->hasil->total_benar ?? 0 }}</td>
                    </tr>

                    <tr>
                        <th>Total Salah</th>
                        <td>{{ $pesertaUjian->hasil->total_salah ?? 0 }}</td>
                    </tr>

                    <tr>
                        <th>Total Kosong</th>
                        <td>{{ $pesertaUjian->hasil->total_kosong ?? 0 }}</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1">
                    Detail Jawaban
                </h4>

                <p class="text-muted mb-0">
                    Review jawaban dan pembahasan soal
                </p>

            </div>

        </div>

        @foreach($pesertaUjian->jawaban as $i => $jawab)

            <div class="border rounded-4 p-4 mb-4 bg-light">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold mb-0">
                        Soal {{ $i + 1 }}
                    </h5>

                    @if($jawab->is_correct)

                        <span class="badge bg-success">
                            Benar
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Salah
                        </span>

                    @endif

                </div>

                <p class="fw-semibold fs-5">
                    {{ $jawab->soal->pertanyaan }}
                </p>

                <div class="row g-3 mt-2">

                    <div class="col-md-6">

                        <div class="border rounded-3 p-3 bg-white h-100">

                            <small class="text-muted d-block mb-2">
                                Jawaban Kamu
                            </small>

                            <span class="badge bg-primary px-3 py-2">
                                {{ $jawab->jawaban }}
                            </span>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="border rounded-3 p-3 bg-white h-100">

                            <small class="text-muted d-block mb-2">
                                Jawaban Benar
                            </small>

                            <span class="badge bg-success px-3 py-2">
                                {{ $jawab->soal->jawaban_benar }}
                            </span>

                        </div>

                    </div>

                </div>

                <div class="mt-4">

                    <div class="border-start border-4 border-success bg-white rounded-3 p-4">

                        <h6 class="fw-bold text-success mb-3">
                            <i class="bi bi-book"></i>
                            Pembahasan
                        </h6>

                        <p class="mb-0 text-secondary">

                            {{ $jawab->soal->pembahasan ?? 'Belum ada pembahasan.' }}

                        </p>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection