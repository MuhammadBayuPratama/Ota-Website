@extends('layouts.app_admin')

@section('title', 'Edit Kamar')

@section('content')
<h2 class="text-2xl font-bold mb-4">Edit Kamar</h2>
<form action="{{ route('admin.kamar.update', $kamar->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label>Nama Kamar</label>
        <input type="text" name="name" class="w-full border p-2 rounded" value="{{ $kamar->name }}" required>
    </div>

    <div class="mb-4">
        <label>Harga</label>
        <input type="number" name="price" class="w-full border p-2 rounded" value="{{ $kamar->price }}" required>
    </div>

    <div class="mb-4">
        <label>Deskripsi</label>
        <textarea name="description" class="w-full border p-2 rounded" rows="3" required>{{ $kamar->description }}</textarea>
    </div>

    <div class="mb-4">
        <label>Kategori</label>
        <select name="id_category" class="w-full border p-2 rounded" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $cat->id == $kamar->id_category ? 'selected' : '' }}>
                    {{ $cat->category }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Jumlah Kamar</label>
        <input type="number" name="jumlah" class="w-full border p-2 rounded" min="0" value="{{ $kamar->jumlah }}" required>
    </div>

    <div class="mb-4">
        <label>Gambar (kosongkan jika tidak ingin ganti)</label>
        <input type="file" name="image" class="w-full border p-2 rounded">
        @if($kamar->image)
            <img src="{{ asset($kamar->image) }}" alt="{{ $kamar->name }}" class="w-32 h-32 object-cover mt-2 rounded">
        @endif
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
