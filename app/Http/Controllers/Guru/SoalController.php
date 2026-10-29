<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\{Ujian, Soal};
use Illuminate\Http\Request;

class SoalController extends Controller
{
    public function index(Ujian $ujian)
    {
        
        $soal = $ujian->soal()->orderBy('urutan')->get();
        return view('guru.soal.index', compact('ujian', 'soal'));
    }

    public function create(Ujian $ujian)
    {
        
        return view('guru.soal.create', compact('ujian'));
    }

    public function store(Request $request, Ujian $ujian)
    {
        
        $validated = $request->validate([
            'pertanyaan'   => 'required|string',
            'gambar'       => 'nullable|image|max:2048',
            'opsi_a'       => 'required|string',
            'opsi_b'       => 'required|string',
            'opsi_c'       => 'required|string',
            'opsi_d'       => 'required|string',
            'jawaban_benar'=> 'required|in:A,B,C,D',
            'pembahasan'   => 'nullable|string',
            'poin'         => 'required|integer|min:1',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('soal', 'public');
        }

        $validated['ujian_id'] = $ujian->id;
        $validated['urutan']   = $ujian->soal()->count() + 1;

        Soal::create($validated);
        $ujian->increment('jumlah_soal');

        return redirect()->route('guru.soal.index', $ujian)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Ujian $ujian, Soal $soal)
    {
        
        return view('guru.soal.edit', compact('ujian', 'soal'));
    }

    public function update(Request $request, Ujian $ujian, Soal $soal)
    {
        
        $validated = $request->validate([
            'pertanyaan'   => 'required|string',
            'opsi_a'       => 'required|string',
            'opsi_b'       => 'required|string',
            'opsi_c'       => 'required|string',
            'opsi_d'       => 'required|string',
            'jawaban_benar'=> 'required|in:A,B,C,D',
            'pembahasan'   => 'nullable|string',
            'poin'         => 'required|integer|min:1',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('soal', 'public');
        }

        $soal->update($validated);
        return redirect()->route('guru.soal.index', $ujian)->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Ujian $ujian, Soal $soal)
    {
      
        $soal->delete();
        $ujian->decrement('jumlah_soal');
        return back()->with('success', 'Soal berhasil dihapus.');
    }
}
