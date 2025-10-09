@extends('layouts.app_admin')

@section('title', 'Edit Layanan Tambahan: ' . $addon->name)

@section('content')
<div class="min-h-screen py-12 px-4 mt-20">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-2xl p-8 sm:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">Edit Add-on: {{ $addon->name }}</h1>
            
            {{-- Menggunakan method PUT/PATCH --}}
            <form action="{{ route('addons.update', $addon->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT') 
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Layanan (Add-on)</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $addon->name) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Per Unit/Per Hari)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $addon->price) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                           min="0" required>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $addon->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end space-x-4 pt-4">
                    <a href="{{ route('addons.index') }}" 
                       class="px-6 py-2.5 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-150">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition duration-150 font-semibold">
                        Perbarui Add-on
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection