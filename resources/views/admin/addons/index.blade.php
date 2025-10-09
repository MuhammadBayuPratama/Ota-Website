@extends('layouts.app_admin')

@section('title', 'Daftar Layanan Tambahan (Add-ons)')

@section('content')
{{-- Perbaikan: Sesuaikan margin kiri (pl) jika konten utama Anda tidak full-width. --}}
{{-- Saya akan asumsikan layout.app Anda sudah menangani struktur sidebar. --}}

<div class="py-12 px-4 sm:px-6 lg:px-8 ml-60">
    <div class="max-w-7xl mx-auto">
        
        {{-- Pesan Status (SUCCESS) --}}
        {{-- Perbaikan: Posisikan pesan notifikasi agar lebih menonjol di atas judul --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg text-center font-medium">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- Header & Tombol Tambah --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pengelolaan Layanan Tambahan (Add-ons)</h1>
                <p class="text-gray-600 mt-1">Kelola semua pilihan layanan dan fasilitas tambahan untuk pemesanan.</p>
            </div>
            <a href="{{ route('admin.addons.create') }}" 
               class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-indigo-700 transition duration-150 flex items-center font-semibold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Add-on Baru
            </a>
        </div>
        
        {{-- Add-ons Grid --}}
        @if($addons->isEmpty())
            <div class="text-center py-16 bg-white rounded-xl shadow-lg border border-gray-200">
                <p class="text-xl text-gray-600">Belum ada layanan tambahan yang terdaftar.</p>
                <p class="text-gray-500 mt-2">Silakan klik "Tambah Add-on Baru" untuk mulai menambahkan layanan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($addons as $addon)
                <div class="bg-white rounded-xl shadow-xl overflow-hidden p-6 border border-gray-100 transition-shadow duration-300 hover:shadow-2xl">
                    <h2 class="text-xl font-bold text-gray-900 mb-1 truncate">{{ $addon->name }}</h2>
                    
                    <p class="text-4xl font-extrabold text-blue-600 mb-3">
                        Rp {{ number_format($addon->price, 0, ',', '.') }}
                    </p>
                    
                    {{-- Deskripsi dengan tinggi tetap untuk konsistensi kartu --}}
                    <p class="text-sm text-gray-500 mb-6 line-clamp-2 h-10">
                        {{ $addon->description ?? 'Tidak ada deskripsi.' }}
                    </p>

                    {{-- Action Buttons --}}
                    <div class="flex justify-end space-x-3 border-t pt-4">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.addons.edit', $addon->id) }}" 
                           class="flex-1 text-center py-2 px-4 text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition duration-150 font-medium">
                            Edit
                        </a>
                        
                        {{-- Tombol Delete --}}
                        <form action="{{ route('addons.destroy', $addon->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus add-on {{ $addon->name }}? Aksi ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-2 px-4 text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition duration-150 font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection