<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\{Ujian, PesertaUjian, JawabanSiswa, HasilUjian, Soal};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UjianController extends Controller
{
    public function index()
    {
        $ujianTersedia = PesertaUjian::where('siswa_id', Auth::id())
            ->with('ujian')
            ->get();
        return view('siswa.ujian.index', compact('ujianTersedia'));
    }

    public function mulai(Ujian $ujian)
    {
        $peserta = PesertaUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', Auth::id())
            ->firstOrFail();

        if ($peserta->status === 'selesai') {
            return redirect()->route('siswa.hasil', $peserta)->with('info', 'Anda sudah menyelesaikan ujian ini.');
        }

        // Set waktu mulai jika belum pernah mulai
        if (!$peserta->mulai_at) {
            $peserta->update(['mulai_at' => now(), 'status' => 'berlangsung']);
        }

        // Cek apakah waktu sudah habis
        $sisaWaktu = $peserta->sisa_waktu;
        if ($sisaWaktu <= 0) {
            return $this->submit(request(), $ujian);
        }

        $soal = $ujian->acak_soal
            ? $ujian->soal()->inRandomOrder()->get()
            : $ujian->soal()->orderBy('urutan')->get();

        $jawabanSebelumnya = JawabanSiswa::where('peserta_ujian_id', $peserta->id)
            ->pluck('jawaban', 'soal_id');

        return view('siswa.ujian.kerjakan', compact('ujian', 'peserta', 'soal', 'jawabanSebelumnya', 'sisaWaktu'));
    }

    public function simpanJawaban(Request $request, Ujian $ujian)
    {
        $peserta = PesertaUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', Auth::id())
            ->where('status', 'berlangsung')
            ->firstOrFail();

        // Cek timeout
        if ($peserta->sisa_waktu <= 0) {
            return $this->prosesSubmit($peserta, $ujian);
        }

        $request->validate([
            'soal_id' => 'required|exists:soal,id',
            'jawaban' => 'required|in:A,B,C,D',
        ]);

        $soal = Soal::findOrFail($request->soal_id);
        $isCorrect = strtoupper($request->jawaban) === strtoupper($soal->jawaban_benar);

        JawabanSiswa::updateOrCreate(
            ['peserta_ujian_id' => $peserta->id, 'soal_id' => $soal->id],
            [
                'jawaban'        => $request->jawaban,
                'is_correct'     => $isCorrect,
                'poin_diperoleh' => $isCorrect ? $soal->poin : 0,
            ]
        );

        return response()->json(['success' => true, 'is_correct' => null]); // jangan reveal jawaban saat ujian
    }

    public function submit(Request $request, Ujian $ujian)
    {
        $peserta = PesertaUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', Auth::id())
            ->firstOrFail();

        if ($peserta->status === 'selesai') {
            return redirect()->route('siswa.hasil', $peserta);
        }

        return $this->prosesSubmit($peserta, $ujian);
    }

    private function prosesSubmit(PesertaUjian $peserta, Ujian $ujian)
    {
        DB::transaction(function () use ($peserta, $ujian) {
            $peserta->update(['selesai_at' => now(), 'status' => 'selesai']);

            $totalSoal   = $ujian->soal()->count();
            $totalBenar  = JawabanSiswa::where('peserta_ujian_id', $peserta->id)->where('is_correct', true)->count();
            $totalJawab  = JawabanSiswa::where('peserta_ujian_id', $peserta->id)->count();
            $totalSalah  = $totalJawab - $totalBenar;
            $totalKosong = $totalSoal - $totalJawab;
            $nilai       = $totalSoal > 0 ? round(($totalBenar / $totalSoal) * 100, 2) : 0;
            $durasi      = $peserta->mulai_at ? now()->diffInSeconds($peserta->mulai_at) : 0;

            HasilUjian::create([
                'peserta_ujian_id'  => $peserta->id,
                'total_benar'       => $totalBenar,
                'total_salah'       => $totalSalah,
                'total_kosong'      => $totalKosong,
                'nilai'             => $nilai,
                'durasi_pengerjaan' => $durasi,
                'submitted_at'      => now(),
            ]);
        });

        return redirect()->route('siswa.hasil', $peserta)->with('success', 'Ujian berhasil dikumpulkan!');
    }

    public function hasil(PesertaUjian $pesertaUjian)
    {
        abort_if($pesertaUjian->siswa_id !== Auth::id(), 403);
        $pesertaUjian->load(['ujian', 'hasil', 'jawaban.soal']);
        return view('siswa.ujian.hasil', compact('pesertaUjian'));
    }
}
