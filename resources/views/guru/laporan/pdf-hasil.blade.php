<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a1a; }
        .header { text-align: center; border-bottom: 2px solid #1e3a5f; padding-bottom: 10px; margin-bottom: 16px; }
        .header h2 { font-size: 16px; margin: 0; color: #1e3a5f; }
        .header p { margin: 2px 0; font-size: 10px; color: #555; }
        .info-row { display: flex; gap: 16px; margin-bottom: 14px; }
        .info-box { flex: 1; background: #f0f4f8; border-radius: 5px; padding: 8px 10px; text-align: center; }
        .info-box .val { font-size: 18px; font-weight: 700; color: #1e3a5f; }
        .info-box .lbl { font-size: 9px; color: #666; }
        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        thead tr { background: #1e3a5f; color: white; }
        th, td { border: 1px solid #ddd; padding: 5px 7px; }
        tr:nth-child(even) { background: #f7f9fb; }
        .lulus { color: #065f46; font-weight: 700; }
        .tidak-lulus { color: #991b1b; font-weight: 700; }
        .footer { margin-top: 20px; text-align: right; font-size: 9px; color: #999; }
    </style>
</head>
<body>
<div class="header">
    <h2>LAPORAN HASIL TRYOUT ONLINE</h2>
    <p>{{ $ujian->judul }} — {{ $ujian->mata_pelajaran }}</p>
    <p>Tanggal: {{ \Carbon\Carbon::parse($ujian->tanggal_mulai)->format('d F Y') }} | Durasi: {{ $ujian->durasi_menit }} menit</p>
    <p>Guru: {{ $ujian->guru->name }} | Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
</div>

<!-- Statistik ringkas -->
<table style="width:100%;border:none;margin-bottom:14px;font-size:10px">
    <tr>
        <td style="border:none;padding:0">
            <table style="width:100%;border:none">
                <tr>
                    <td style="border:none;background:#f0f4f8;border-radius:5px;padding:6px 10px;text-align:center;width:22%">
                        <div style="font-size:15px;font-weight:700;color:#1e3a5f">{{ $hasil->count() }}</div>
                        <div style="font-size:9px;color:#666">Total Peserta</div>
                    </td>
                    <td style="border:none;width:2%"></td>
                    <td style="border:none;background:#f0f4f8;border-radius:5px;padding:6px 10px;text-align:center;width:22%">
                        <div style="font-size:15px;font-weight:700;color:#1e3a5f">{{ number_format($rata, 1) }}</div>
                        <div style="font-size:9px;color:#666">Rata-rata Nilai</div>
                    </td>
                    <td style="border:none;width:2%"></td>
                    <td style="border:none;background:#f0f4f8;border-radius:5px;padding:6px 10px;text-align:center;width:22%">
                        <div style="font-size:15px;font-weight:700;color:#065f46">{{ number_format($tertinggi, 1) }}</div>
                        <div style="font-size:9px;color:#666">Nilai Tertinggi</div>
                    </td>
                    <td style="border:none;width:2%"></td>
                    <td style="border:none;background:#f0f4f8;border-radius:5px;padding:6px 10px;text-align:center;width:22%">
                        <div style="font-size:15px;font-weight:700;color:#991b1b">{{ number_format($terendah, 1) }}</div>
                        <div style="font-size:9px;color:#666">Nilai Terendah</div>
                    </td>
                    <td style="border:none;width:2%"></td>
                    <td style="border:none;background:#f0f4f8;border-radius:5px;padding:6px 10px;text-align:center;width:22%">
                        <div style="font-size:15px;font-weight:700;color:#1e3a5f">{{ $lulus }}/{{ $hasil->count() }}</div>
                        <div style="font-size:9px;color:#666">Lulus (≥70)</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- Tabel nilai -->
<table>
    <thead>
        <tr>
            <th style="width:4%">No</th>
            <th>Nama Siswa</th>
            <th style="width:12%">NIS</th>
            <th style="width:10%">Benar</th>
            <th style="width:10%">Salah</th>
            <th style="width:10%">Kosong</th>
            <th style="width:10%">Nilai</th>
            <th style="width:12%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hasil as $no => $p)
        <tr>
            <td style="text-align:center">{{ $no + 1 }}</td>
            <td>{{ $p->siswa->name }}</td>
            <td style="text-align:center">{{ $p->siswa->nis ?? '-' }}</td>
            <td style="text-align:center">{{ optional($p->hasil)->total_benar ?? '-' }}</td>
            <td style="text-align:center">{{ optional($p->hasil)->total_salah ?? '-' }}</td>
            <td style="text-align:center">{{ optional($p->hasil)->total_kosong ?? '-' }}</td>
            <td style="text-align:center;font-weight:700">{{ optional($p->hasil)->nilai ?? '-' }}</td>
            <td style="text-align:center">
                @if($p->status === 'selesai')
                    @if(optional($p->hasil)->nilai >= 70)
                        <span class="lulus">LULUS</span>
                    @else
                        <span class="tidak-lulus">REMEDIAL</span>
                    @endif
                @else
                    <span style="color:#888">Belum selesai</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">Dokumen ini digenerate otomatis oleh Sistem Tryout Online</div>
</body>
</html>