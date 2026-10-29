@extends('layouts.app')

@section('title', 'Edit Ujian')
@section('page_title', 'Edit Ujian')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        @if ($errors->any())

            <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">

                <div class="fw-semibold mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Terjadi Kesalahan
                </div>

                <ul class="mb-0 ps-3">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <div class="mb-4">

                    <h3 class="fw-bold mb-1">
                        Edit Ujian
                    </h3>

                    <p class="text-muted mb-0">
                        Perbarui data ujian yang sudah dibuat
                    </p>

                </div>

                <form action="{{ route('guru.ujian.update', $ujian) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-12">

                            <label class="form-label fw-semibold">
                                Judul Ujian
                            </label>

                            <input type="text"
                                   name="judul"
                                   value="{{ old('judul', $ujian->judul) }}"
                                   class="form-control rounded-3 py-2"
                                   placeholder="Contoh: Tryout Matematika">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Mata Pelajaran
                            </label>

                            <input type="text"
                                   name="mata_pelajaran"
                                   value="{{ old('mata_pelajaran', $ujian->mata_pelajaran) }}"
                                   class="form-control rounded-3 py-2"
                                   placeholder="Contoh: Matematika">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Durasi (Menit)
                            </label>

                            <input type="number"
                                   name="durasi_menit"
                                   value="{{ old('durasi_menit', $ujian->durasi_menit) }}"
                                   class="form-control rounded-3 py-2"
                                   placeholder="60">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Tanggal Mulai
                            </label>

                            <input type="datetime-local"
                                   name="tanggal_mulai"
                                   value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($ujian->tanggal_mulai)->format('Y-m-d\TH:i')) }}"
                                   class="form-control rounded-3 py-2">

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Tanggal Selesai
                            </label>

                            <input type="datetime-local"
                                   name="tanggal_selesai"
                                   value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($ujian->tanggal_selesai)->format('Y-m-d\TH:i')) }}"
                                   class="form-control rounded-3 py-2">

                        </div>

                        <div class="col-md-12">

                            <label class="form-label fw-semibold">
                                Deskripsi
                            </label>

                            <textarea name="deskripsi"
                                      rows="4"
                                      class="form-control rounded-3"
                                      placeholder="Masukkan deskripsi ujian">{{ old('deskripsi', $ujian->deskripsi) }}</textarea>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Status Ujian
                            </label>
                        
                            <select name="status"
                                    class="form-select rounded-3 py-2">
                        
                                <option value="draft"
                                    {{ old('status', $ujian->status ?? '') == 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>
                        
                                <option value="aktif"
                                    {{ old('status', $ujian->status ?? '') == 'aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>
                        
                                <option value="selesai"
                                    {{ old('status', $ujian->status ?? '') == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                        
                            </select>
                        
                        </div>

                        <div class="col-md-12">

                            <div class="card bg-light border-0 rounded-4">

                                <div class="card-body">

                                    <h6 class="fw-bold mb-3">
                                        Pengaturan Ujian
                                    </h6>

                                    <div class="form-check mb-3">

                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="acak_soal"
                                               value="1"
                                               id="acak_soal"
                                               {{ old('acak_soal', $ujian->acak_soal) ? 'checked' : '' }}>

                                        <label class="form-check-label fw-medium" for="acak_soal">
                                            Acak Soal
                                        </label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="acak_jawaban"
                                               value="1"
                                               id="acak_jawaban"
                                               {{ old('acak_jawaban', $ujian->acak_jawaban) ? 'checked' : '' }}>

                                        <label class="form-check-label fw-medium" for="acak_jawaban">
                                            Acak Jawaban
                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <a href="{{ route('guru.dashboard') }}"
                           class="btn btn-light rounded-pill px-4">

                            Batal

                        </a>

                        <button type="submit"
                                class="btn btn-success rounded-pill px-4">

                            <i class="bi bi-save me-1"></i>
                            Update Ujian

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection