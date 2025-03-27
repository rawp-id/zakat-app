@csrf
<div class="mb-4">
    <h6 class="">Nama</h6>
    <input type="text" name="name" class="form-control" placeholder="Masukan Nama"
        value="{{ old('name', $zakat->name ?? '') }}" required>
</div>

@if (!Auth::user()->is_admin || !Auth::user()->master)
    <div class="mb-4">
        <h6 class="">Telepon</h6>
        <input type="text" name="phone" class="form-control" placeholder="Masukan Nomor Telepon" value="{{ old('phone', $zakat->phone ?? '') }}"
            required>
    </div>
@endif
<div class="mb-4">
    <h6 class="">Jumlah</h6>
    <input type="number" name="amount" class="form-control" placeholder="Masukan Jumlah" value="{{ old('amount', $zakat->amount ?? '') }}"
        required>
</div>
<div class="mb-4">
    <h6 class="">Alamat</h6>
    <textarea name="address" class="form-control" placeholder="Masukan Alamat" required>{{ old('address', $zakat->address ?? '') }}</textarea>
</div>

<!-- Input Dynamic Part of Zakat -->
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between">
        <h6>Rincian (Nama Orang yang Zakat)</h6>
        <button type="button" id="addPartOfZakat" class="ms-2 btn btn-outline-primary btn-sm mt-2"><i
                class="bi bi-plus-circle"></i></button>
    </div>
    <div id="partOfZakatContainer">
        @php
            $partOfZakat = old('part_of_zakat', json_decode($zakat->part_of_zakat ?? '[]', true) ?? []);
        @endphp
        @foreach ($partOfZakat as $key => $person)
            <div class="input-group mb-4">
                <input type="text" name="part_of_zakat[]" class="form-control" value="{{ $person }}" required>
                <button type="button" class="btn btn-danger remove-field mb-0">Hapus</button>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between">
        <h6>Deskripsi</h6>
        <button type="button" id="toggle-description" class="btn btn-outline-primary btn-sm">
            Tambah Deskripsi
        </button>
    </div>

    <textarea name="description" id="description" class="form-control mt-1" placeholder="Masukan Deskripsi Atau Pertanyaan!" style="display: none;">
        {{ old('description', $zakat->description ?? '') }}
    </textarea>
</div>

<script>
    document.getElementById('toggle-description').addEventListener('click', function() {
        var descriptionField = document.getElementById('description');
        if (descriptionField.style.display === 'none') {
            descriptionField.style.display = 'block';
            this.innerText = 'Sembunyikan Deskripsi';
        } else {
            descriptionField.style.display = 'none';
            this.innerText = 'Tambah Deskripsi';
        }
    });
</script>


@if (Auth::user()->master)
    <div class="mb-4">
        <h6 class="">Status</h6>
        <select name="status" class="form-control">
            <option value="pending" {{ old('status', $zakat->status ?? '') == 'pending' ? 'selected' : '' }}>Pending
            </option>
            <option value="approved" {{ old('status', $zakat->status ?? '') == 'approved' ? 'selected' : '' }}>Approved
            </option>
            <option value="rejected" {{ old('status', $zakat->status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected
            </option>
        </select>
    </div>
@endif
<div class="d-flex justify-content-end gap-2">
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('zakats.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addPartOfZakat').addEventListener('click', function() {
            let container = document.getElementById('partOfZakatContainer');
            let div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');
            div.innerHTML = `
            <input type="text" name="part_of_zakat[]" class="form-control" required>
            <button type="button" class="btn btn-danger remove-field mb-0">Hapus</button>
        `;
            container.appendChild(div);
        });

        document.getElementById('partOfZakatContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-field')) {
                e.target.parentElement.remove();
            }
        });
    });
</script>
