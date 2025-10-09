@extends('layouts.app_admin')

@section('title', 'Kelola Kamar')

@section('content')
<div class="max-w-6xl mx-auto mt-6 ml-60">
    <h1 class="text-3xl font-bold mb-6">Kelola Kamar</h1>

    <a href="{{ route('admin.kamar.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">
        Tambah Kamar Baru
    </a>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Kamar</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Harga</th>
                    <th class="px-6 py-3 text-left">Jumlah</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($kamars as $kamar)
                <tr>
                    <td class="px-6 py-4">{{ $kamar->name }}</td>
                    <td class="px-6 py-4">{{ $kamar->category->category ?? '-' }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($kamar->price,0,',','.') }}</td>
                    <td class="px-6 py-4">{{ $kamar->jumlah }}</td>
                    <td class="px-6 py-4">
                        @if($kamar->jumlah > 0)
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-sm">Tersedia</span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-sm">Penuh</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('admin.kamar.edit', $kamar->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                        <form action="{{ route('admin.kamar.destroy', $kamar->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                onclick="return confirm('Yakin ingin hapus kamar ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
