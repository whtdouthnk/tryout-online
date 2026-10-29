<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Ujian, User, PesertaUjian};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{
    public function index()
    {
        $ujian = Ujian::where('guru_id', Auth::id())
            ->withCount(['soal', 'peserta'])
            ->latest()
            ->paginate(10);
        return view('guru.ujian.index', compact('ujian'));
    }

    public function create()
    {
        return view('guru.ujian.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'mata_pelajaran'  => 'required|string|max:100',
            'durasi_menit'    => 'required|integer|min:5|max:300',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'acak_soal'       => 'boolean',
            'acak_jawaban'    => 'boolean',
        ]);
    
        $validated['guru_id'] = Auth::id();
    
        $validated['acak_soal'] = $request->boolean('acak_soal');
    
        $validated['acak_jawaban'] = $request->boolean('acak_jawaban');
    
        $validated['status'] = 'draft';
    
        $validated['jumlah_soal'] = 0;
    
        $ujian = Ujian::create($validated);
    
        return redirect()->route('guru.soal.index', $ujian)
            ->with('success', 'Ujian berhasil dibuat.');
    }

    public function edit(Ujian $ujian)
    {
        
        return view('guru.ujian.edit', compact('ujian'));
    }

    public function update(Request $request, Ujian $ujian)
    {
        
        $validated = $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'mata_pelajaran'  => 'required|string|max:100',
            'durasi_menit'    => 'required|integer|min:5|max:300',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status'          => 'required|in:draft,aktif,selesai',
            'acak_soal'       => 'boolean',
            'acak_jawaban'    => 'boolean',
        ]);
        $ujian->update($validated);
        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy(Ujian $ujian)
    {
        
        $ujian->delete();
        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil dihapus.');
    }

    // ── Manajemen Peserta ──────────────────────────────────────────────────

    public function peserta(Ujian $ujian)
    {
        
        $pesertaSudahAda = $ujian->siswa()->pluck('users.id')->toArray();
        $semuaSiswa = User::where('role', 'siswa')->orderBy('name')->get();
        return view('guru.ujian.peserta', compact('ujian', 'semuaSiswa', 'pesertaSudahAda'));
    }

    public function tambahPeserta(Request $request, Ujian $ujian)
    {
        
        $request->validate(['siswa_ids' => 'required|array', 'siswa_ids.*' => 'exists:users,id']);

        foreach ($request->siswa_ids as $siswaId) {
            PesertaUjian::firstOrCreate([
                'ujian_id' => $ujian->id,
                'siswa_id' => $siswaId,
            ]);
        }

        return back()->with('success', count($request->siswa_ids) . ' siswa berhasil ditambahkan.');
    }

    public function hapusPeserta(Ujian $ujian, User $siswa)
    {
        
        PesertaUjian::where('ujian_id', $ujian->id)
            ->where('siswa_id', $siswa->id)
            ->delete();
        return back()->with('success', 'Peserta berhasil dihapus.');
    }

    // ── Hasil Ujian ────────────────────────────────────────────────────────

    public function hasil(Ujian $ujian)
    {
        
        $hasil = $ujian->peserta()
            ->with(['siswa', 'hasil'])
            ->get()
            ->sortByDesc(fn($p) => optional($p->hasil)->nilai);
        return view('guru.ujian.hasil', compact('ujian', 'hasil'));
    }
}
