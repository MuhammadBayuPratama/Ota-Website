@extends('layouts.app_admin')

@section('title', 'Kelola Fasilitas')

@section('content')
<div class="max-w-6xl mx-auto mt-6 ml-60">
    <h1 class="text-3xl font-bold mb-6">Kelola Fasilitas</h1>

    <a href="{{ route('admin.fasilitas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">
        Tambah Fasilitas Baru
    </a>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Nama Fasilitas</th>
                    <th class="px-6 py-3 text-left">Harga</th>
                    <th class="px-6 py-3 text-left">Deskripsi</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($fasilitas as $f)
                <tr>
                    <td class="px-6 py-4">{{ $f->name }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($f->price,0,',','.') }}</td>
                    <td class="px-6 py-4">{{ $f->description }}</td>
                    <td class="px-6 py-4">
                        @if($f->status == 'active')
                            <span class="bg-green-500 text-white px-2 py-1 rounded text-sm">Tersedia</span>
                        @elseif($f->status == 'inactive')
                            <span class="bg-red-500 text-white px-2 py-1 rounded text-sm">Penuh</span>
                        @else
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">{{ $f->status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('admin.fasilitas.edit', $f->id) }}" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                        <form action="{{ route('admin.fasilitas.destroy', $f->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                onclick="return confirm('Yakin ingin hapus fasilitas ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
