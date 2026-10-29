@extends('layouts.app')

@section('title', 'Mengerjakan: '.$ujian->judul)
@section('page_title', '📝 '.$ujian->judul)

@push('styles')
<style>
    .soal-nav button { width:38px; height:38px; font-size:.85rem; border-radius:6px; margin:2px; }
    .soal-nav .dijawab { background:#1e3a5f; color:#fff; border-color:#1e3a5f; }
    .timer-box { font-size: 2rem; font-weight: 700; font-family: monospace; }
    .timer-danger { color: #dc3545; animation: blink 1s infinite; }
    @keyframes blink { 0%,100%{opacity:1}50%{opacity:.4} }
    .opsi-label { cursor:pointer; border:2px solid #dee2e6; border-radius:8px; padding:.75rem 1rem;
                  display:block; transition:.15s; }
    .opsi-label:hover { border-color: #2d6a9f; background:#f0f7ff; }
    input[type=radio]:checked + .opsi-label { border-color:#1e3a5f; background:#e8f0fe; font-weight:600; }
    input[type=radio] { display:none; }
</style>
@endpush

@section('content')
<div class="row g-3">
    <!-- Soal area -->
    <div class="col-lg-8">
        <div class="card p-4">
            <div id="soal-container">
                @foreach($soal as $i => $s)
                <div class="soal-item" id="soal-{{ $s->id }}" style="{{ $i > 0 ? 'display:none' : '' }}">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="badge bg-secondary">Soal {{ $i+1 }} dari {{ $soal->count() }}</span>
                        <span class="badge bg-light text-dark">{{ $s->poin }} poin</span>
                    </div>
                    <p class="fs-5 fw-medium">{{ $s->pertanyaan }}</p>
                    @if($s->gambar)
                        <img src="{{ asset('storage/'.$s->gambar) }}" class="img-fluid rounded mb-3" style="max-height:250px">
                    @endif

                    @foreach(['A','B','C','D'] as $opsi)
                    <div class="mb-2">
                        <input type="radio" name="jawaban_{{ $s->id }}" id="j_{{ $s->id }}_{{ $opsi }}"
                               value="{{ $opsi }}"
                               {{ isset($jawabanSebelumnya[$s->id]) && $jawabanSebelumnya[$s->id] == $opsi ? 'checked' : '' }}
                               onchange="simpanJawaban({{ $s->id }}, '{{ $opsi }}', {{ $i }})">
                        <label for="j_{{ $s->id }}_{{ $opsi }}" class="opsi-label">
                            <strong>{{ $opsi }}.</strong> {{ $s->{'opsi_'.strtolower($opsi)} }}
                        </label>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button class="btn btn-outline-secondary" id="btn-prev" onclick="navigasi(-1)" disabled>← Sebelumnya</button>
                <button class="btn btn-outline-primary" id="btn-next" onclick="navigasi(1)">Selanjutnya →</button>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Timer -->
        <div class="card p-3 text-center mb-3">
            <div class="text-muted small mb-1">Sisa Waktu</div>
            <div class="timer-box" id="timer">--:--</div>
        </div>

        <!-- Navigasi soal -->
        <div class="card p-3 mb-3">
            <div class="small fw-semibold mb-2">Navigasi Soal</div>
            <div class="soal-nav" id="soal-nav">
                @foreach($soal as $i => $s)
                <button class="btn btn-sm btn-outline-secondary {{ isset($jawabanSebelumnya[$s->id]) ? 'dijawab' : '' }}"
                        id="nav-{{ $s->id }}" onclick="goTo({{ $i }})">{{ $i+1 }}</button>
                @endforeach
            </div>
            <div class="d-flex gap-2 mt-2 small">
                <span><span class="badge" style="background:#1e3a5f">■</span> Dijawab</span>
                <span><span class="badge bg-outline border">■</span> Belum</span>
            </div>
        </div>

        <!-- Submit -->
        <div class="card p-3">
            <button class="btn btn-success w-100 fw-semibold" onclick="konfirmasiSubmit()">
                ✅ Kumpulkan Jawaban
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Submit -->
<div class="modal fade" id="modalSubmit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Konfirmasi Pengumpulan</h5></div>
            <div class="modal-body" id="modal-body-text"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Periksa Lagi</button>
                <form method="POST" action="{{ route('siswa.ujian.submit', $ujian) }}" id="form-submit">
                    @csrf
                    <button type="submit" class="btn btn-success">Ya, Kumpulkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const soalList = @json($soal->pluck('id'));
const totalSoal = soalList.length;
let current = 0;
let dijawab = new Set(@json(array_keys($jawabanSebelumnya->toArray())).map(String));

// Timer
let sisaDetik = {{ $sisaWaktu }};
const timerEl = document.getElementById('timer');
const timerInterval = setInterval(() => {
    if (sisaDetik <= 0) {
        clearInterval(timerInterval);
        document.getElementById('form-submit').submit();
        return;
    }
    sisaDetik--;
    const m = Math.floor(sisaDetik / 60).toString().padStart(2,'0');
    const s = (sisaDetik % 60).toString().padStart(2,'0');
    timerEl.textContent = m + ':' + s;
    if (sisaDetik <= 120) timerEl.classList.add('timer-danger');
}, 1000);

function navigasi(arah) {
    const soalItems = document.querySelectorAll('.soal-item');
    soalItems[current].style.display = 'none';
    current = Math.max(0, Math.min(totalSoal - 1, current + arah));
    soalItems[current].style.display = '';
    document.getElementById('btn-prev').disabled = current === 0;
    document.getElementById('btn-next').disabled = current === totalSoal - 1;
}

function goTo(idx) {
    const soalItems = document.querySelectorAll('.soal-item');
    soalItems[current].style.display = 'none';
    current = idx;
    soalItems[current].style.display = '';
    document.getElementById('btn-prev').disabled = current === 0;
    document.getElementById('btn-next').disabled = current === totalSoal - 1;
}

function simpanJawaban(soalId, jawaban, idx) {
    dijawab.add(String(soalId));
    document.getElementById('nav-' + soalId)?.classList.add('dijawab');

    fetch('{{ route("siswa.ujian.jawab", $ujian) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ soal_id: soalId, jawaban: jawaban }),
    });
}

function konfirmasiSubmit() {
    const belum = totalSoal - dijawab.size;
    document.getElementById('modal-body-text').innerHTML =
        `<p>Anda telah menjawab <strong>${dijawab.size}</strong> dari <strong>${totalSoal}</strong> soal.</p>`
        + (belum > 0 ? `<p class="text-warning">⚠️ Masih ada <strong>${belum}</strong> soal yang belum dijawab.</p>` : '')
        + `<p>Yakin ingin mengumpulkan jawaban sekarang?</p>`;
    new bootstrap.Modal(document.getElementById('modalSubmit')).show();
}
</script>
@endpush
