@extends('layouts.app_admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="max-w-6xl mx-auto mt-6 ml-60">
    <h1 class="text-3xl font-bold mb-6">Kelola Kategori</h1>

    <a href="{{ route('admin.category.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">
        Tambah Kategori Baru
    </a>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Kategori</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $cat)
                <tr>
                    <td class="px-6 py-4">{{ $cat->category }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('admin.category.edit', $cat->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                        <form action="{{ route('admin.category.destroy', $cat->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                onclick="return confirm('Yakin ingin hapus kategori ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
