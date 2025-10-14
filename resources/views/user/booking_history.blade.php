@extends('layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
<div class="max-w-5xl mx-auto mt-10 px-4 mt-[150px] mb-[100px]">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-12 text-center">Riwayat Booking</h1>

    {{-- Booking Kamar --}}
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-2">Booking Kamar</h2>
        @if($bookingsKamar->isEmpty())
            <div class="p-8 bg-gray-100 rounded-xl text-center text-gray-500 shadow-inner">
                Belum ada booking kamar.
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
                @foreach($bookingsKamar as $b)
                    {{-- CARD CONTAINER SEBAGAI LINK BLOCK --}}
                    {{-- Pastikan route 'booking.show' sudah diarahkan ke function detail universal (showDetail) --}}
                    <a href="{{ route('booking.show.detail', ['type' => 'kamar', 'id' => $b->id]) }}" class="block p-6 bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl hover:border-blue-400 transition-all duration-300 group relative">

                        {{-- Konten Utama Card --}}
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600">
                                {{ $b->kamar->name ?? 'Booking Anda' }}
                            </h3>
                            <span class="ml-4 px-3 py-1 text-xs font-semibold rounded-full uppercase flex-shrink-0
                                {{ $b->status === 'diproses' ? 'bg-yellow-100 text-yellow-800' : ($b->status === 'pending' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($b->status) }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-700 space-y-2 mb-4">
                            <p><strong>Check-in:</strong> <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($b->check_in)->format('d-m-Y') }}</span></p>
                            <p><strong>Check-out:</strong> <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($b->check_out)->format('d-m-Y') }}</span></p>
                            <p><strong>Total:</strong> <span class="font-bold text-lg text-blue-600">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</span></p>
                        </div>
                        
                        {{-- TOMBOL BATALKAN: Membutuhkan event.stopPropagation() --}}
                        @if($b->status === 'diproses')
                            {{-- onclick="event.stopPropagation()" mencegah klik tombol memicu tautan <a> --}}
                            <div class="mt-4" onclick="event.stopPropagation()">
                                <form action="{{ route('booking.cancel', $b->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking kamar ini?')">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        Batalkan Booking
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Indikator Klik --}}
                        <p class="mt-4 text-xs text-blue-500 font-semibold text-right group-hover:underline">Lihat Detail &raquo;</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <hr class="my-10 border-gray-200">

    {{-- Booking Fasilitas --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 pb-2">Booking Fasilitas</h2>
        @if($bookingsFasilitas->isEmpty())
            <div class="p-8 bg-gray-100 rounded-xl text-center text-gray-500 shadow-inner">
                Belum ada booking fasilitas.
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-2">
                @foreach($bookingsFasilitas as $b)
                    {{-- CARD CONTAINER SEBAGAI LINK BLOCK --}}
                    {{-- Pastikan route 'booking.show.fasilitas' sudah diarahkan ke function detail universal (showDetail) --}}
                    <a href="{{ route('booking.show.detail', ['type' => 'fasilitas', 'id' => $b->id]) }}" class="block p-6 bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl hover:border-blue-400 transition-all duration-300 group relative">
                        
                        {{-- Konten Utama Card --}}
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600">
                                {{ $b->fasilitas->name ?? 'Booking Fasilitas' }}
                            </h3>
                            <span class="ml-4 px-3 py-1 text-xs font-semibold rounded-full uppercase flex-shrink-0
                                {{ $b->status === 'diproses' ? 'bg-yellow-100 text-yellow-800' : ($b->status === 'pending' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($b->status) }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-700 space-y-2 mb-4">
                            <p><strong>Check-in:</strong> <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($b->check_in)->format('d-m-Y') }}</span></p>
                            <p><strong>Check-out:</strong> <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($b->check_out)->format('d-m-Y') }}</span></p>
                            <p><strong>Total:</strong> <span class="font-bold text-lg text-blue-600">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</span></p>
                        </div>

                        {{-- TOMBOL BATALKAN: Membutuhkan event.stopPropagation() --}}
                        @if($b->status === 'diproses')
                            {{-- onclick="event.stopPropagation()" mencegah klik tombol memicu tautan <a> --}}
                            <div class="mt-4" onclick="event.stopPropagation()">
                                <form action="{{ route('booking.cancel.fasilitas', $b->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan booking fasilitas ini?')">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        Batalkan Booking
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- Indikator Klik --}}
                        <p class="mt-4 text-xs text-blue-500 font-semibold text-right group-hover:underline">Lihat Detail &raquo;</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection