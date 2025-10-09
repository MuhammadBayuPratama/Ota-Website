@extends('layouts.app_admin')

@section('title', 'Tambah Kamar')

@section('content')
<div class="ml-60">
    <h2 class="text-2xl font-bold mb-4">Tambah Kamar</h2>
    <form action="{{ route('admin.kamar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label>Nama Kamar</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Harga</label>
            <input type="number" name="price" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Deskripsi</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="3" required></textarea>
        </div>

        <div class="mb-4">
            <label>Kategori</label>
            <select name="id_category" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>Jumlah Kamar</label>
            <input type="number" name="jumlah" class="w-full border p-2 rounded" min="0" required>
        </div>

        <!-- Tambahan kapasitas -->
        <div class="mb-4">
            <label>Maksimal Dewasa</label>
            <input type="number" name="max_adults" class="w-full border p-2 rounded" value="2" min="1" required>
        </div>

        <div class="mb-4">
            <label>Maksimal Anak (usia ≥ 3 tahun)</label>
            <input type="number" name="max_children" class="w-full border p-2 rounded" value="1" min="0" required>
        </div>

        <div class="mb-4">
            <label>Maksimal Anak (usia < 3 tahun)</label>
            <input type="number" name="max_infants" class="w-full border p-2 rounded" value="2" min="0" required>
        </div>
        <!-- End kapasitas -->

        <div class="mb-4">
            <label>Gambar</label>
            <input type="file" name="image" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
