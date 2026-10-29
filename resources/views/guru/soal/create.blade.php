@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Tambah Soal</h3>
            <small class="text-muted">{{ $ujian->judul }}</small>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('guru.soal.store', $ujian->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- PERTANYAAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Pertanyaan</label>
                    <textarea name="pertanyaan"
                              class="form-control"
                              rows="3"
                              placeholder="Tulis soal di sini..."></textarea>
                </div>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Opsi A</label>
                        <input type="text" name="opsi_a" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Opsi B</label>
                        <input type="text" name="opsi_b" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Opsi C</label>
                        <input type="text" name="opsi_c" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Opsi D</label>
                        <input type="text" name="opsi_d" class="form-control">
                    </div>

                </div>

                <div class="row g-3 mt-2">

                    <div class="col-md-4">
                        <label class="form-label">Jawaban Benar</label>
                        <select name="jawaban_benar" class="form-select">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" class="form-control" value="10">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control" value="1">
                    </div>

                </div>

                <div class="mt-3">
                    <label class="form-label">Pembahasan</label>
                    <textarea name="pembahasan" class="form-control" rows="3"></textarea>
                </div>

                <div class="mt-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('guru.soal.index', $ujian->id) }}"
                       class="btn btn-outline-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-success px-4">
                        Simpan Soal
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection