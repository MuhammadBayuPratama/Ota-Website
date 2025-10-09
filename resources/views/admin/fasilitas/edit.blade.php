@extends('layouts.app_admin')

@section('title', 'Edit Fasilitas')

@section('content')
<div>
    <div class="max-w-6xl mx-auto mt-6 ml-60">
        <h2 class="text-2xl font-bold mb-4">Edit Fasilitas</h2>
<form action="{{ route('admin.fasilitas.update', $fasilitas->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label>Nama Fasilitas</label>
        <input type="text" name="name" class="w-full border p-2 rounded" value="{{ $fasilitas->name }}" required>
    </div>

    <div class="mb-4">
        <label>Deskripsi</label>
        <textarea name="description" class="w-full border p-2 rounded" required>{{ $fasilitas->description }}</textarea>
    </div>

    <div class="mb-4">
        <label>Harga</label>
        <input type="number" name="price" class="w-full border p-2 rounded" value="{{ $fasilitas->price }}" required>
    </div>

    <div class="mb-4">
        <label>Status</label>
        <select name="status" class="w-full border p-2 rounded" required>
            <option value="">-- Pilih Status --</option>
            <option value="Tersedia" {{ $fasilitas->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="Tidak Tersedia" {{ $fasilitas->status == 'Tidak Tersedia' ? 'selected' : '' }}>Penuh</option>
        </select>
    </div>

    <div class="mb-4">
        <label>Kategori</label>
        <select name="id_category" class="w-full border p-2 rounded" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $fasilitas->id_category == $cat->id ? 'selected' : '' }}>
                    {{ $cat->category }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Gambar (kosongkan jika tidak ingin ganti)</label>
        <input type="file" name="image" class="w-full border p-2 rounded">
        <div class="mt-2">
            <img src="{{ asset($fasilitas->image) }}" alt="{{ $fasilitas->name }}" class="w-32 h-32 object-cover rounded">
        </div>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
</form>
</div>

@endsection
    