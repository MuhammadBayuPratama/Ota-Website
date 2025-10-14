@extends('layouts.app')

{{-- 1. Tentukan variabel booking yang aktif --}}
@php
    $activeBooking = $bookingKamar ?? $bookingFasilitas;
    $idTransaksi = $activeBooking->id ?? 'N/A';
    $totalHarga = $activeBooking->total_harga ?? 0;
    $typeLabel = $type === 'kamar' ? 'Kamar' : ($type === 'fasilitas' ? 'Fasilitas' : 'Transaksi');

    // Fungsi helper untuk status
    $status = $activeBooking->status ?? 'pending';
    $statusMap = [
        'diproses' => ['bg' => 'bg-yellow-500', 'text' => 'text-white', 'icon' => '⏳'],
        'pending' => ['bg' => 'bg-orange-500', 'text' => 'text-white', 'icon' => '🕒'],
        'dibatalkan' => ['bg' => 'bg-red-600', 'text' => 'text-white', 'icon' => '❌'],
        'selesai' => ['bg' => 'bg-green-600', 'text' => 'text-white', 'icon' => '✅'],
        'dibayar' => ['bg' => 'bg-blue-600', 'text' => 'text-white', 'icon' => '💳'],
        'checkin' => ['bg' => 'bg-blue-600', 'text' => 'text-white', 'icon' => '✅'],
        'checkout' => ['bg' => 'bg-gray-600', 'text' => 'text-white', 'icon' => '✅'],
    ];
    $statusStyle = $statusMap[$status] ?? ['bg' => 'bg-gray-400', 'text' => 'text-white', 'icon' => '❓'];
    
    // Formatting tanggal
    $checkIn = \Carbon\Carbon::parse($activeBooking->check_in ?? now());
    $checkOut = \Carbon\Carbon::parse($activeBooking->check_out ?? now());
@endphp

@section('title', 'Detail Booking ' . $typeLabel)

@section('content')
<div class="max-w-6xl mx-auto mt-24 md:mt-32 px-4 mb-16">
    
    {{-- HEADER JUDUL & STATUS (Lebih Bold dan Kontras) --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 pb-4 border-b-4 border-gray-900">
        <div>
            <p class="text-sm font-semibold uppercase tracking-widest text-gray-500 mb-1">
                DETAIL {{ strtoupper($typeLabel) }}
            </p>
            <h1 class="text-5xl font-extrabold text-gray-900 leading-none">
                <span class="text-blue-600">#</span>{{ $idTransaksi }}
            </h1>
        </div>
        
        {{-- BADGE STATUS UNIK --}}
        <div class="mt-4 sm:mt-0 flex items-center p-2 rounded-lg {{ $statusStyle['bg'] }} shadow-lg">
            <span class="text-2xl mr-2 leading-none">{{ $statusStyle['icon'] }}</span>
            <span class="text-lg font-bold uppercase tracking-wider {{ $statusStyle['text'] }}">
                {{ strtoupper($status) }}
            </span>
        </div>
    </div>

    @if ($activeBooking)
        
        {{-- RINGKASAN TRANSAKSI (Card Minimalis dengan Fokus Tipografi) --}}
        <div class="bg-white shadow-2xl rounded-2xl p-8 md:p-12 mb-12 border border-gray-100">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b pb-3">Ringkasan Pembayaran</h2>

            <div class="grid md:grid-cols-3 gap-8 text-base">
                
                {{-- Total Pembayaran --}}
                <div class="space-y-1">
                    <p class="text-sm text-gray-500 font-medium">TOTAL PEMBAYARAN</p>
                    <span class="text-4xl font-black text-gray-900 block leading-tight">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                    <span class="text-sm text-green-600 font-semibold">{{ $activeBooking->status === 'dibayar' ? 'Pembayaran Lunas' : 'Lunas' }}</span>
                </div>
                
                {{-- Periode Booking --}}
                <div class="space-y-1 border-l pl-4 border-gray-200">
                    <p class="text-sm text-gray-500 font-medium">CHECK-IN</p>
                    <p class="text-2xl font-bold text-gray-800 leading-tight">{{ $checkIn->format('d F Y') }}</p>
                    <p class="text-sm text-gray-500 font-medium mt-4">CHECK-OUT</p>
                    <p class="text-2xl font-bold text-gray-800 leading-tight">{{ $checkOut->format('d F Y') }}</p>
                </div>
                
                {{-- Durasi --}}
                <div class="space-y-1 border-l pl-4 border-gray-200">
                    <p class="text-sm text-gray-500 font-medium">DURASI</p>
                    <p class="text-4xl font-black text-blue-600 leading-tight">{{ $activeBooking->durasi }}</p>
                    <p class="text-xl font-bold text-gray-800">Hari</p>
                </div>
            </div>
        </div>
        
        {{-- KONTEN DETAIL SPESIFIK BERDASARKAN TIPE BOOKING --}}
        
        @if ($type === 'kamar' && $bookingKamar)
            
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Detail Kamar</h2>
            
            <div class="space-y-6">
                @php
                    $durasi = $bookingKamar->durasi ?? 1;
                @endphp

                @foreach($bookingKamar->detailBookings as $detail)
                    @php
                        $kamar = $detail->kamar;
                        $kamarPrice = $kamar->price ?? 0;
                        $subtotal = $kamarPrice * $durasi;
                        $image = asset($kamar->image ?? 'images/default-room.jpg');
                        $roomName = $kamar->name ?? 'Kamar Dihapus';
                    @endphp
                    
                    {{-- CARD DETAIL KAMAR (Gaya Dashboard Admin) --}}
                    <div class="flex flex-col md:flex-row bg-white rounded-xl shadow-lg hover:shadow-xl transition-all border border-gray-100 p-6">
                        
                        {{-- GAMBAR --}}
                        <div class="flex-shrink-0 w-full md:w-56 h-40 md:h-auto overflow-hidden rounded-xl mb-4 md:mb-0">
                            <img class="w-full h-full object-cover" src="{{ $image }}" alt="{{ $roomName }}">
                        </div>
                        
                        {{-- DETAIL & INFO --}}
                        <div class="md:ml-8 flex-grow">
                            
                            {{-- Nama Kamar (Header) --}}
                            <div class="border-b pb-2 mb-4">
                                <h3 class="text-2xl font-extrabold text-gray-900">{{ $roomName }}</h3>
                            </div>

                            <dl class="divide-y divide-gray-100">
                                {{-- Nama Tamu --}}
                                <div class="flex justify-between py-3">
                                    <dt class="text-sm font-medium text-gray-500">Tamu Menginap</dt>
                                    <dd class="text-sm font-semibold text-gray-900">{{ $detail->Nama_Tamu ?? 'N/A' }}</dd>
                                </div>

                                {{-- Kapasitas --}}
                                <div class="flex justify-between py-3">
                                    <dt class="text-sm font-medium text-gray-500">Kapasitas</dt>
                                    <dd class="text-sm font-semibold text-gray-900">
                                        {{ $detail->dewasa ?? 0 }} Dewasa, {{ $detail->anak ?? 0 }} Anak
                                    </dd>
                                </div>
                                
                                {{-- Harga Satuan --}}
                                <div class="flex justify-between py-3">
                                    <dt class="text-sm font-medium text-gray-500">Harga Satuan / Malam</dt>
                                    <dd class="text-sm font-semibold text-gray-900">Rp {{ number_format($kamarPrice, 0, ',', '.') }}</dd>
                                </div>

                                {{-- Subtotal --}}
                                <div class="flex justify-between py-4 border-t border-blue-200 mt-2 bg-blue-50 rounded-b-lg px-2 -mx-2">
                                    <dt class="text-md font-bold text-blue-700">SUBTOTAL ({{ $durasi }} HARI)</dt>
                                    <dd class="text-xl font-extrabold text-blue-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- TOTAL AKHIR SEBAGAI BOX TERPISAH --}}
            <div class="mt-8 p-6 bg-gray-900 rounded-xl shadow-2xl text-white flex justify-between items-center">
                <p class="text-2xl font-extrabold uppercase">TOTAL AKHIR DIBAYAR</p>
                <p class="text-4xl font-black text-yellow-400">Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
            </div>

        @elseif ($type === 'fasilitas' && $bookingFasilitas)
            
            {{-- AMBIL DATA FASILITAS --}}
            @php
                $detailFasilitas = $bookingFasilitas->detailFasilitas->first();
                $fasilitas = $detailFasilitas->fasilitas ?? null; 
                
                $price = $fasilitas->price ?? 0;
                $durasi = $bookingFasilitas->durasi ?? 0;
                $subtotal = $price * $durasi;
            @endphp

            <h2 class="text-3xl font-bold text-gray-900 mb-6">Detail Fasilitas</h2>

            @if ($fasilitas)
                {{-- CARD DETAIL FASILITAS (Gaya Dashboard Admin) --}}
                <div class="flex flex-col md:flex-row bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                    
                    {{-- GAMBAR --}}
                    <div class="flex-shrink-0 w-full md:w-64 h-48 overflow-hidden rounded-xl mb-6 md:mb-0">
                        <img class="w-full h-full object-cover" src="{{ asset($fasilitas->image ?? 'images/default-facility.jpg') }}" alt="{{ $fasilitas->name }}">
                    </div>
                    
                    {{-- DETAIL & HARGA --}}
                    <div class="md:ml-8 flex-grow">
                        
                        {{-- Nama Fasilitas (Header) --}}
                        <div class="border-b pb-2 mb-4">
                            <h3 class="text-3xl font-extrabold text-gray-900">{{ $fasilitas->name }}</h3>
                        </div>

                        <dl class="divide-y divide-gray-100">
                            {{-- Dibooking oleh --}}
                            <div class="flex justify-between py-3">
                                <dt class="text-sm font-medium text-gray-500">Dibooking oleh</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $detailFasilitas->Nama_Tamu ?? 'N/A' }}</dd>
                            </div>

                            {{-- Harga Satuan --}}
                            <div class="flex justify-between py-3">
                                <dt class="text-sm font-medium text-gray-500">Harga Satuan / Hari</dt>
                                <dd class="text-sm font-semibold text-green-600">Rp {{ number_format($price, 0, ',', '.') }}</dd>
                            </div>

                            {{-- Durasi --}}
                            <div class="flex justify-between py-3">
                                <dt class="text-sm font-medium text-gray-500">Durasi Booking</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $durasi }} Hari</dd>
                            </div>
                            
                            {{-- Subtotal --}}
                            <div class="flex justify-between py-4 border-t border-blue-200 mt-2 bg-blue-50 rounded-b-lg px-2 -mx-2">
                                <dt class="text-md font-bold text-blue-700">SUBTOTAL</dt>
                                <dd class="text-3xl font-extrabold text-blue-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- TOTAL AKHIR SEBAGAI BOX TERPISAH --}}
                <div class="mt-8 p-6 bg-gray-900 rounded-xl shadow-2xl text-white flex justify-between items-center">
                    <p class="text-2xl font-extrabold uppercase">TOTAL AKHIR DIBAYAR</p>
                    <p class="text-4xl font-black text-yellow-400">Rp {{ number_format($bookingFasilitas->total_harga, 0, ',', '.') }}</p>
                </div>
                
            @else
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md" role="alert">
                    <p class="font-bold">Kesalahan Data Fasilitas</p>
                    <p class="text-sm">Fasilitas yang dibooking tidak ditemukan.</p>
                </div>
            @endif
            
        @else
             <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md" role="alert">
                 <p class="font-bold">Error!</p>
                 <p class="text-sm">Data booking untuk tipe '{{ $typeLabel }}' tidak ditemukan atau tidak valid.</p>
             </div>
        @endif
    @else
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md" role="alert">
            <p class="font-bold">Data Tidak Ditemukan</p>
            <p class="text-sm">Maaf, detail booking dengan No. Transaksi #{{ $idTransaksi }} tidak dapat ditemukan.</p>
        </div>
    @endif
    
    <hr class="my-16 border-gray-200">

    {{-- Tombol Kembali (Lebih Modern) --}}
    <div class="text-center">
        <a href="{{ route('booking.history')}}" class="inline-flex items-center px-10 py-4 bg-gray-900 text-white text-lg font-bold rounded-full shadow-xl hover:bg-gray-800 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            KEMBALI KE RIWAYAT
        </a>
    </div>
</div>
@endsection