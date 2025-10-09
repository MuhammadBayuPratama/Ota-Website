@extends('layouts.app_admin')

@section('title', 'Tambah Category')

@section('content')
<div class="ml-60">
    <h2 class="text-2xl font-bold mb-4">Tambah Category</h2>
<form action="{{ route('admin.category.store') }}" method="POST">
    @csrf
    <div class="mb-4">
        <label>Nama Category</label>
        <input type="text" name="category" class="w-full border p-2 rounded" required>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
</div>
@endsection
