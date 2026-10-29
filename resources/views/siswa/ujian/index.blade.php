@extends('layouts.app')

@section('title', 'Daftar Ujian')
@section('page_title', 'Daftar Ujian')

@section('content')

<div class="card">
    <div class="card-body">

        <h4 class="mb-4">Daftar Ujian</h4>

        <table class="table table-bordered align-middle">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Mata Pelajaran</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($ujianTersedia as $key => $item)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>{{ $item->ujian->judul }}</td>

                        <td>{{ $item->ujian->mata_pelajaran }}</td>

                        <td>{{ $item->ujian->durasi_menit }} Menit</td>

                        <td>

                            @if($item->status == 'selesai')

                                <span class="badge bg-success">
                                    Selesai
                                </span>

                            @elseif($item->status == 'berlangsung')

                                <span class="badge bg-warning">
                                    Berlangsung
                                </span>

                            @else

                                <span class="badge bg-primary">
                                    Belum Mulai
                                </span>

                            @endif

                        </td>

                        <td>

                            @if($item->status == 'selesai')

                                <a
                                    href="{{ route('siswa.hasil', $item->id) }}"
                                    class="btn btn-success btn-sm"
                                >
                                    Hasil
                                </a>

                            @else

                                <a
                                    href="{{ route('siswa.ujian.mulai', $item->ujian_id) }}"
                                    class="btn btn-primary btn-sm"
                                >
                                    Kerjakan
                                </a>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada ujian
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection