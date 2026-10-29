<div>
    <label>Judul Ujian</label>
    <input type="text"
        name="judul"
        value="{{ old('judul', $ujian->judul ?? '') }}"
        required>
</div>

<br>

<div>
    <label>Mata Pelajaran</label>
    <input type="text"
        name="mata_pelajaran"
        value="{{ old('mata_pelajaran', $ujian->mata_pelajaran ?? '') }}"
        required>
</div>

<br>

<div>
    <label>Deskripsi</label>

    <textarea name="deskripsi" rows="5">{{ old('deskripsi', $ujian->deskripsi ?? '') }}</textarea>
</div>

<br>

<div>
    <label>Durasi (Menit)</label>

    <input type="number"
        name="durasi_menit"
        value="{{ old('durasi_menit', $ujian->durasi_menit ?? '') }}"
        required>
</div>

<br>

<div>
    <label>Tanggal Mulai</label>

    <input type="datetime-local"
        name="tanggal_mulai"
        value="{{ old('tanggal_mulai', isset($ujian) ? \Carbon\Carbon::parse($ujian->tanggal_mulai)->format('Y-m-d\TH:i') : '') }}"
        required>
</div>

<br>

<div>
    <label>Tanggal Selesai</label>

    <input type="datetime-local"
        name="tanggal_selesai"
        value="{{ old('tanggal_selesai', isset($ujian) ? \Carbon\Carbon::parse($ujian->tanggal_selesai)->format('Y-m-d\TH:i') : '') }}"
        required>
</div>

<br>

<div>
    <label>Status</label>

    <select name="status">
        <option value="draft"
            {{ old('status', $ujian->status ?? '') == 'draft' ? 'selected' : '' }}>
            Draft
        </option>

        <option value="publish"
            {{ old('status', $ujian->status ?? '') == 'publish' ? 'selected' : '' }}>
            Publish
        </option>
    </select>
</div>

<br>