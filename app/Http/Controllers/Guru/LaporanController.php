<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\PesertaUjian;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Cetak laporan PDF per ujian
     */
    public function cetakPdf($ujianId)
    {
        // Ambil data ujian
        $ujian = Ujian::with('guru')->findOrFail($ujianId);
        
        // Validasi kepemilikan
        if ($ujian->guru_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Ambil data peserta ujian
        $hasil = PesertaUjian::with(['siswa', 'hasil'])
            ->where('ujian_id', $ujianId)
            ->get();
        
        // Hitung statistik dari peserta yang sudah selesai
        $selesai = $hasil->filter(function ($p) {
            return $p->status === 'selesai' && $p->hasil;
        });
        
        $rata = $selesai->avg(function ($p) {
            return $p->hasil->nilai ?? 0;
        }) ?? 0;
        
        $tertinggi = $selesai->max(function ($p) {
            return $p->hasil->nilai ?? 0;
        }) ?? 0;
        
        $terendah = $selesai->min(function ($p) {
            return $p->hasil->nilai ?? 0;
        }) ?? 0;
        
        $lulus = $selesai->filter(function ($p) {
            return ($p->hasil->nilai ?? 0) >= 70;
        })->count();
        
        $data = [
            'ujian' => $ujian,
            'hasil' => $hasil,
            'rata' => $rata,
            'tertinggi' => $tertinggi,
            'terendah' => $terendah,
            'lulus' => $lulus,
        ];
        
        // Load view PDF
        $pdf = Pdf::loadView('guru.laporan.pdf-hasil', $data);
        $pdf->setPaper('a4', 'portrait');
        
        // Stream ke browser
        return $pdf->stream('laporan-hasil-ujian-' . $ujian->judul . '.pdf');
    }
}