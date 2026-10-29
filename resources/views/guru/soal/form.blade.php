<div>
    <label>Pertanyaan</label>
    <textarea name="pertanyaan" required>{{ old('pertanyaan', $soal->pertanyaan ?? '') }}</textarea>
</div>

<br>

<div>
    <label>Opsi A</label>
    <input type="text"
           name="opsi_a"
           value="{{ old('opsi_a', $soal->opsi_a ?? '') }}"
           required>
</div>

<div>
    <label>Opsi B</label>
    <input type="text"
           name="opsi_b"
           value="{{ old('opsi_b', $soal->opsi_b ?? '') }}"
           required>
</div>

<div>
    <label>Opsi C</label>
    <input type="text"
           name="opsi_c"
           value="{{ old('opsi_c', $soal->opsi_c ?? '') }}"
           required>
</div>

<div>
    <label>Opsi D</label>
    <input type="text"
           name="opsi_d"
           value="{{ old('opsi_d', $soal->opsi_d ?? '') }}"
           required>
</div>

<br>

<div>
    <label>Jawaban Benar</label>

    <select name="jawaban_benar">

        <option value="A"
            {{ old('jawaban_benar', $soal->jawaban_benar ?? '') == 'A' ? 'selected' : '' }}>
            A
        </option>

        <option value="B"
            {{ old('jawaban_benar', $soal->jawaban_benar ?? '') == 'B' ? 'selected' : '' }}>
            B
        </option>

        <option value="C"
            {{ old('jawaban_benar', $soal->jawaban_benar ?? '') == 'C' ? 'selected' : '' }}>
            C
        </option>

        <option value="D"
            {{ old('jawaban_benar', $soal->jawaban_benar ?? '') == 'D' ? 'selected' : '' }}>
            D
        </option>

    </select>
</div>

<br>

<div>
    <label>Poin</label>

    <input type="number"
           name="poin"
           value="{{ old('poin', $soal->poin ?? 10) }}">
</div>

<br>

<div>
    <label>Pembahasan</label>

    <textarea name="pembahasan">{{ old('pembahasan', $soal->pembahasan ?? '') }}</textarea>
</div>

<br>

<div>
    <label>Gambar</label>
    <input type="file" name="gambar">
</div>

@if(isset($soal) && $soal->gambar)
    <br>

    <img src="{{ asset('storage/' . $soal->gambar) }}"
         width="150">
@endif