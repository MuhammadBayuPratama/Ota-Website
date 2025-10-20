@extends('layouts.app')

@section('title', 'Pointer Hotel - Find Your Perfect Stay')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<section id="home" class="relative min-h-screen overflow-hidden pt-[72px]">
    <div class="absolute inset-0 z-0">
        <img src="/resort.jpeg" alt="Luxury Hotel" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    </div>
    
    <div class="relative z-10 flex items-center justify-center min-h-[calc(100vh-72px)] py-16 px-6">
        <div class="text-center text-white max-w-4xl">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">
                Find Your
                <span class="text-transparent bg-clip-text 
                             bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400">
                    Perfect Stay.
                </span>
            </h1>

            <p class="text-xl md:text-2xl mb-4 text-gray-200 leading-relaxed">
                Book Hotels And Facility & Curated experiences.
            </p>

            <p class="text-lg mb-12 text-gray-300">
                Tailored For Those Who Travel With Taste
            </p>

            <a href="#rooms-section" 
               class="inline-flex items-center space-x-2 bg-white text-gray-900 px-8 py-4 
                      rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 
                      shadow-lg hover:shadow-xl transform hover:-translate-y-1 group">
                <span>Booking Now</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

{{-- Container Utama Diperbaiki --}}
<main class="bg-gray-50">

    <!-- Filter Section dengan Desain Modern -->
<section class="container mx-auto py-8 px-6">
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 shadow-md">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0 gap-4">
            <!-- Filter Status -->
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Status Kamar
                </label>
                <select id="filter-status" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white shadow-sm hover:border-blue-400">
                    <option value="all">🏨 Semua Kamar</option>
                    <option value="available">✅ Tersedia</option>
                    <option value="full">🚫 Penuh / Tidak Tersedia</option>
                </select>
            </div>
            
            <!-- Sort Harga -->
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                    Urutkan Harga
                </label>
                <select id="sort-price" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all bg-white shadow-sm hover:border-purple-400">
                    <option value="asc">💰 Termurah → Termahal</option>
                    <option value="desc">💎 Termahal → Termurah</option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="flex-shrink-0 lg:self-end">
                <button id="reset-filters" class="w-full lg:w-auto bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </button>
            </div>
        </div>

        <!-- Result Counter -->
        <div class="mt-4 pt-4 border-t border-gray-200">
            <p id="result-count" class="text-sm text-gray-600 font-medium"></p>
        </div>
    </div>
</section>

<section id="rooms" class="py-10 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-4">
                Pilihan Kamar Terbaik
            </h2>
            <p class="text-gray-600 text-lg">Temukan kamar yang sempurna untuk pengalaman menginap Anda</p>
        </div>
        
        <div 
            x-data="{ 
                active: 0, 
                total: {{ count($kamars) }},
                itemsPerView: 1, // State baru untuk items yang terlihat
                itemWidth: 0,
                calculateItemsPerView() {
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 768) return 2;
                    return 1;
                },
                updateDimensions() {
                    // 1. Update itemsPerView
                    this.itemsPerView = this.calculateItemsPerView();
                    
                    // 2. Hitung itemWidth yang baru
                    // Jika sliderContainer belum dirender/tidak ada, gunakan fallback (misalnya 0)
                    if (this.$refs.sliderContainer) {
                        this.itemWidth = this.$refs.sliderContainer.clientWidth / this.itemsPerView;
                    }

                    // 3. Sesuaikan posisi aktif (active) jika melebihi batas baru (PENTING saat resize)
                    const maxActive = Math.max(0, this.total - this.itemsPerView);
                    this.active = Math.min(this.active, maxActive);
                    this.active = Math.max(0, this.active);
                },
                init() { 
                    this.$nextTick(() => { 
                        this.updateDimensions();
                    });
                    window.addEventListener('resize', () => {
                        this.updateDimensions();
                    });
                }
            }" 
            class="relative w-full overflow-hidden"
        >
            <div class="flex justify-end space-x-3 mb-6">
                <button 
                    @click="active = Math.max(0, active - 1)" 
                    :disabled="active === 0"
                    class="bg-white text-2xl rounded-full shadow-xl w-14 h-14 flex items-center justify-center transition-all duration-300 border-2 border-gray-200 group"
                    :class="active === 0 ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-gradient-to-r hover:from-blue-600 hover:to-purple-600 hover:text-white hover:border-transparent'"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <button 
                    @click="active = Math.min(total - itemsPerView, active + 1)" 
                    :disabled="active >= total - itemsPerView"
                    class="bg-white text-2xl rounded-full shadow-xl w-14 h-14 flex items-center justify-center transition-all duration-300 border-2 border-gray-200 group"
                    :class="active >= total - itemsPerView ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-gradient-to-r hover:from-blue-600 hover:to-purple-600 hover:text-white hover:border-transparent'"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <div 
                x-ref="sliderContainer"
                class="flex transition-transform duration-700 ease-in-out -mx-3"
                :style="`transform: translateX(-${active * itemWidth}px);`"
                id="rooms-container"
            >
                @foreach($kamars as $index => $kamar)
                    @php
                        $activeDetailBookings = $kamar->detailBookings()->whereHas('booking', function ($query) { 
                            $query->whereIn('status', ['diproses', 'checkin']);
                        })->count();
                        $isFull = $activeDetailBookings >= $kamar->jumlah; 
                        $availableCount = $kamar->jumlah - $activeDetailBookings;
                    @endphp

                    <div class="room-card px-3 flex-shrink-0" 
                        data-status="{{ $isFull ? 'full' : 'available' }}"
                        data-price="{{ $kamar->price }}"
                        :style="`width: ${itemWidth}px;`">
                        <div class="rounded-xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 overflow-hidden bg-white h-full flex flex-col border border-gray-100">
                            
                            <div class="relative overflow-hidden group">
                                <img src="{{ $kamar->image }}" class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105">
                                
                                <div class="absolute inset-0 bg-black/10"></div>

                                @if($isFull)
                                    <span class="absolute top-4 left-4 bg-red-600 text-white text-sm font-semibold px-3 py-1 rounded-full flex items-center gap-1 shadow">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        Penuh
                                    </span>
                                @else
                                    <span class="absolute top-4 left-4 bg-green-600 text-white text-sm font-semibold px-3 py-1 rounded-full flex items-center gap-1 shadow">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Tersedia
                                    </span>
                                @endif

                                <div class="absolute bottom-4 left-4 bg-black/50 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                    {{ $availableCount }}/{{ $kamar->jumlah }} Kamar
                                </div>
                                
                            </div>

                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="text-2xl font-extrabold mb-1 text-gray-900">{{ $kamar->name }}</h3>
                                <p class="text-gray-500 text-sm mb-3">
                                    {{ $kamar->category_name ?? 'Kamar' }} 
                                </p>
                                
                                <p class="text-gray-600 mb-4 line-clamp-3 flex-grow leading-relaxed">{{ $kamar->description }}</p>
                                
                                <div class="flex gap-x-4 gap-y-2 flex-wrap mb-4 text-gray-500 text-sm">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 10.14l-.01 2.36.01 2.5a2 2 0 01-2 2H7a2 2 0 01-2-2v-4a2 2 0 012-2h8.04L15 8h-4V4H7v4H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2V10.14zM16 4h4v4h-4zM7 16h4v-4H7z"></path></svg>
                                        AC
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 16h-2v-6h2v6zm0-8H11V6h2v4z"></path></svg>
                                        WiFi
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14z"></path></svg>
                                        TV
                                    </span>
                                </div>

                                <div class="border-t pt-4 mt-auto">
                                    <p class="font-bold text-gray-900 mb-4">
                                        <span class="text-4xl text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 font-extrabold">
                                            Rp {{ number_format($kamar->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-sm text-gray-500 font-normal">/malam</span>
                                    </p>

                                    @auth
                                        @if($isFull)
                                            <button disabled class="w-full bg-gray-300 text-gray-500 py-3 rounded-lg cursor-not-allowed font-semibold flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                                Tidak Tersedia
                                            </button>
                                        @else
                                            <a href="{{ route('booking.create', ['kamar_id' => $kamar->id]) }}" 
                                                class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg text-center hover:shadow-lg transition-all duration-300 font-bold hover:scale-[1.01] flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Booking Sekarang
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" 
                                            class="block w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white py-3 rounded-lg text-center hover:from-gray-700 hover:to-gray-800 font-bold transition-all duration-300 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                            Login untuk Booking
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-center space-x-3 mt-8">
                <template x-for="(kamar, index) in Array.from({ length: total - itemsPerView + 1 }, (_, i) => i)" :key="index">
                    <button 
                        class="w-3 h-3 rounded-full transition-all duration-300 hover:scale-125"
                        :class="active === index ? 'bg-gradient-to-r from-blue-600 to-purple-600 w-8' : 'bg-gray-300'"
                        @click="active = index">
                    </button>
                </template>
            </div>
        </div>

        <div class="text-center mt-16">
            <a href="{{route('allrooms')}}" class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-10 py-4 rounded-full hover:shadow-2xl transition-all duration-300 font-bold text-lg hover:scale-105">
                <span>Lihat Semua Kamar</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<script>
// Filter dan Sort Functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterStatus = document.getElementById('filter-status');
    const sortPrice = document.getElementById('sort-price');
    const resetButton = document.getElementById('reset-filters');
    const roomsContainer = document.getElementById('rooms-container');
    const resultCount = document.getElementById('result-count');

    function applyFiltersAndSort() {
        const rooms = Array.from(document.querySelectorAll('.room-card'));
        const statusFilter = filterStatus.value;
        const sortOrder = sortPrice.value;

        // Filter berdasarkan status
        let visibleRooms = rooms.filter(room => {
            const status = room.getAttribute('data-status');
            if (statusFilter === 'all') return true;
            return status === statusFilter;
        });

        // Sort berdasarkan harga
        visibleRooms.sort((a, b) => {
            const priceA = parseInt(a.getAttribute('data-price'));
            const priceB = parseInt(b.getAttribute('data-price'));
            return sortOrder === 'asc' ? priceA - priceB : priceB - priceA;
        });

        // Sembunyikan semua room terlebih dahulu
        rooms.forEach(room => {
            room.style.display = 'none';
        });

        // Tampilkan room yang sudah difilter dan disort
        visibleRooms.forEach(room => {
            room.style.display = '';
            roomsContainer.appendChild(room);
        });

        // Update result counter
        const availableCount = visibleRooms.filter(r => r.getAttribute('data-status') === 'available').length;
        const fullCount = visibleRooms.filter(r => r.getAttribute('data-status') === 'full').length;
        
        resultCount.innerHTML = `
            Menampilkan <strong>${visibleRooms.length}</strong> kamar 
            (<span class="text-green-600">${availableCount} tersedia</span>, 
            <span class="text-red-600">${fullCount} penuh</span>)
        `;
    }

    // Event listeners
    filterStatus.addEventListener('change', applyFiltersAndSort);
    sortPrice.addEventListener('change', applyFiltersAndSort);
    
    resetButton.addEventListener('click', function() {
        filterStatus.value = 'all';
        sortPrice.value = 'asc';
        applyFiltersAndSort();
    });

    // Initial load
    applyFiltersAndSort();
});
</script>
    {{-- Section Hero/Service yang Awalnya di main --}}
    <section class="py-16 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                Your Journey, Our Priority
            </h1>
            <p class="text-xl text-gray-600 mb-12">
                Ensuring Every Trip is Hassle Free
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 relative overflow-hidden rounded-2xl shadow-xl group">
                    <div class="h-96 md:h-[500px] relative">
                        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2080&q=80" 
                             alt="Luxury Hotel Pool" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 md:p-8">
                            <h3 class="text-3xl md:text-4xl font-bold text-white mb-3">Relax. Refresh. Rejuvenate.</h3>
                            <p class="text-white/90 text-base md:text-lg">
                                Treat yourself to a peaceful escape with our<br>
                                soothing spa treatments and expert care
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="relative overflow-hidden rounded-2xl shadow-xl group">
                        <div class="h-48 md:h-60 relative">
                            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Spa Refresh" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4 md:p-6">
                                <h3 class="text-2xl md:text-3xl font-bold text-white">Refresh</h3>
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-hidden rounded-2xl shadow-xl group">
                        <div class="h-48 md:h-60 relative">
                            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" 
                                 alt="Hotel Spa Relax" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4 md:p-6">
                                <h3 class="text-2xl md:text-3xl font-bold text-white">Relax</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section id="facilities" class="py-10 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-4">
                Pilihan Fasilitas Terbaik
            </h2>
            <p class="text-gray-600 text-lg">Temukan fasilitas yang sempurna untuk pengalaman Anda</p>
        </div>

        <div 
            x-data="{ 
                filterStatus: 'all', // State Alpine.js untuk filter status
                sortOrder: 'default', // State Alpine.js untuk urutan sortir (asc/desc)
                active: 0, 
                total: {{ count($facilities) }},
                itemWidth: 0,
                
                // Initialization function
                init() { 
                    this.$nextTick(() => { 
                        this.updateCarouselLayout();
                        this.applyFilters();
                    });
                    window.addEventListener('resize', () => {
                        this.updateCarouselLayout();
                    });
                },
                
                // Function to calculate items per view (kept for slider logic)
                calculateItemsPerView() {
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 768) return 2;
                    return 1;
                },
                
                // Function to update carousel dimensions and total count
                updateCarouselLayout() {
                    if(this.$refs.sliderContainer) {
                        const visibleCards = Array.from(this.$refs.sliderContainer.children).filter(card => card.style.display !== 'none');
                        this.total = visibleCards.length;

                        // Perbarui counter hasil
                        document.getElementById('result-count').innerText = `Menampilkan ${this.total} dari {{ count($facilities) }} fasilitas.`;

                        if (this.total > 0) {
                            this.itemWidth = this.$refs.sliderContainer.clientWidth / this.calculateItemsPerView();
                        } else {
                            this.itemWidth = 0;
                        }
                        
                        // Reset active index jika diperlukan
                        if (this.active >= this.total && this.total > 0) {
                            this.active = this.total - 1;
                        } else if (this.total === 0) {
                            this.active = 0;
                        }
                    }
                },
                
                // Function to apply filters and sorting
                applyFilters: function() {
                    // Ambil nilai dari elemen <select> yang baru
                    this.filterStatus = this.$refs.filterStatus.value;
                    this.sortOrder = this.$refs.sortPrice.value;

                    const container = this.$refs.sliderContainer;
                    const cards = Array.from(container.children);
                    
                    // 1. Filter (Hide/Show)
                    cards.forEach(card => {
                        const status = card.getAttribute('data-status');
                        if (this.filterStatus === 'all' || status === this.filterStatus) {
                            card.style.display = ''; // Show
                        } else {
                            card.style.display = 'none'; // Hide
                        }
                    });

                    // 2. Sort
                    let visibleCards = cards.filter(card => card.style.display !== 'none');
                    
                    if (this.sortOrder !== 'default') {
                        visibleCards.sort((a, b) => {
                            const priceA = parseFloat(a.getAttribute('data-price'));
                            const priceB = parseFloat(b.getAttribute('data-price'));

                            if (this.sortOrder === 'asc') { // Termurah
                                return priceA - priceB;
                            } else if (this.sortOrder === 'desc') { // Termahal
                                return priceB - priceA;
                            }
                            return 0;
                        });
                        
                        // Re-append sorted cards to DOM
                        visibleCards.forEach(card => container.appendChild(card));
                    }
                    
                    // Update layout after filter/sort
                    this.$nextTick(() => {
                        this.updateCarouselLayout();
                    });
                },
                
                // Function to reset all filters
                resetFilters: function() {
                    this.$refs.filterStatus.value = 'all';
                    this.$refs.sortPrice.value = 'default';
                    this.filterStatus = 'all';
                    this.sortOrder = 'default';
                    this.applyFilters();
                }
            }" 
            class="relative w-full overflow-hidden"
        >
            
            <div class="container mx-auto pb-8">
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 shadow-xl border border-gray-100">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center space-y-4 lg:space-y-0 gap-4">
                        
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Status Fasilitas
                            </label>
                            <select 
                                id="filter-status" 
                                x-ref="filterStatus"
                                @change="applyFilters()"
                                class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white shadow-sm hover:border-blue-400 appearance-none"
                            >
                                <option value="all">🏨 Semua Fasilitas</option>
                                <option value="available">✅ Tersedia</option>
                                <option value="full">🚫 Penuh / Tidak Tersedia</option>
                            </select>
                        </div>
                        
                        <div class="flex-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                                Urutkan Harga
                            </label>
                            <select 
                                id="sort-price" 
                                x-ref="sortPrice"
                                @change="applyFilters()"
                                class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all bg-white shadow-sm hover:border-purple-400 appearance-none"
                            >
                                {{-- Menambahkan 'default' agar reset berfungsi sempurna --}}
                                <option value="default">Urutan Default</option> 
                                <option value="asc">💰 Termurah → Termahal</option>
                                <option value="desc">💎 Termahal → Termurah</option>
                            </select>
                        </div>

                        <div class="flex-shrink-0 lg:self-end">
                            <button 
                                id="reset-filters" 
                                @click="resetFilters()"
                                class="w-full lg:w-auto bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl transition-all duration-300 font-semibold shadow-md hover:shadow-lg flex items-center justify-center gap-2 mt-0 lg:mt-6"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset Filter
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p id="result-count" class="text-sm text-gray-600 font-medium"></p>
                    </div>
                </div>
            </div>
            {{-- NAVIGASI CAROUSEL (Dipertahankan) --}}
            <div class="flex justify-end space-x-3 mb-6">
                <button 
                    @click="active = (active - calculateItemsPerView() + total) % total; $nextTick(() => updateCarouselLayout())"
                    :disabled="total <= calculateItemsPerView()"
                    class="bg-white text-2xl rounded-full shadow-xl w-14 h-14 flex items-center justify-center hover:bg-gradient-to-r hover:from-blue-600 hover:to-purple-600 hover:text-white transition-all duration-300 border-2 border-gray-200 hover:border-transparent group disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button 
                    @click="active = (active + calculateItemsPerView()) % total; $nextTick(() => updateCarouselLayout())"
                    :disabled="total <= calculateItemsPerView()"
                    class="bg-white text-2xl rounded-full shadow-xl w-14 h-14 flex items-center justify-center hover:bg-gradient-to-r hover:from-blue-600 hover:to-purple-600 hover:text-white transition-all duration-300 border-2 border-gray-200 hover:border-transparent group disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <div 
                x-ref="sliderContainer"
                class="flex transition-transform duration-700 ease-in-out -mx-3"
                :style="`transform: translateX(-${active * itemWidth}px);`"
                id="rooms-container"
            >
                @foreach($facilities as $facility)
                    @php
                        $activeDetailBookings = $facility->detailfasilitas()
                            ->whereHas('bookingfasilitas', function ($query) { 
                                $query->whereIn('status', ['diproses', 'checkin']);
                            })
                            ->count();
                            
                        $isFull = $activeDetailBookings >= $facility->jumlah; 
                        $availableCount = $facility->jumlah - $activeDetailBookings;
                        @endphp
                        
                        <div class="facilities-card px-3 flex-shrink-0 min-w-full md:min-w-[50%] lg:min-w-[33.3333%]" 
                            data-status="{{ $isFull ? 'full' : 'available' }}"
                            data-price="{{ $facility->price }}"
                        >
                            <div class="rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden bg-white h-full flex flex-col border border-gray-100">
                                <div class="relative overflow-hidden group">
                                    <img src="{{ $facility->image }}" class="w-full h-72 object-cover transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    @if($isFull)
                                        <span class="absolute top-4 left-4 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold px-4 py-2 rounded-full animate-pulse shadow-lg flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Penuh
                                        </span>
                                    @else
                                        <span class="absolute top-4 left-4 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Tersedia
                                        </span>
                                    @endif

                                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-gray-700">
                                        {{ $availableCount }}/{{ $facility->jumlah }} Unit Tersedia
                                    </div>
                                </div>

                                <div class="p-6 flex-grow flex flex-col">
                                    <h3 class="text-2xl font-bold mb-3 text-gray-900">{{ $facility->name }}</h3>
                                    <p class="text-gray-600 mb-4 line-clamp-3 flex-grow leading-relaxed">{{ $facility->description }}</p>
                                    
                                    <div class="flex gap-3 mb-4 text-gray-500 text-sm">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                            AC
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                            </svg>
                                            WiFi
                                        </span>
                                    </div>

                                    <div class="border-t pt-4 mt-auto">
                                        <p class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 font-extrabold text-3xl mb-4">
                                            Rp {{ number_format($facility->price, 0, ',', '.') }} 
                                            <span class="text-sm text-gray-500 font-normal">/hari</span> 
                                        </p>

                                        @auth
                                            @if($isFull)
                                                <button disabled class="w-full bg-gray-300 text-gray-500 py-3 rounded-xl cursor-not-allowed font-semibold flex items-center justify-center gap-2">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Tidak Tersedia
                                                </button>
                                            @else
                                                <a href="{{ route('bookingfasilitas.create', ['facility_id' => $facility->id]) }}" 
                                                    class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl text-center hover:shadow-xl transition-all duration-300 font-bold hover:scale-[1.02] flex items-center justify-center gap-2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    Booking Sekarang
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" 
                                                class="block w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white py-3 rounded-xl text-center hover:from-gray-700 hover:to-gray-800 font-bold transition-all duration-300 flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                                </svg>
                                                Login untuk Booking
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
            
            {{-- DOTS NAVIGASI CAROUSEL --}}
            <div class="flex justify-center space-x-3 mt-8">
                <template x-for="(card, index) in Array.from($refs.sliderContainer.children).filter(c => c.style.display !== 'none')" :key="index">
                    <button 
                        class="w-3 h-3 rounded-full transition-all duration-300 hover:scale-125"
                        :class="active >= index * calculateItemsPerView() && active < (index + 1) * calculateItemsPerView() ? 'bg-gradient-to-r from-blue-600 to-purple-600 w-8' : 'bg-gray-300'"
                        @click="active = index * calculateItemsPerView(); $nextTick(() => updateCarouselLayout())">
                    </button>
                </template>
            </div>

            <div x-show="total === 0" class="text-center py-10 text-gray-500 text-xl font-medium">
                Tidak ada fasilitas yang sesuai dengan kriteria filter. 😥
            </div>
        </div>

        <div class="text-center mt-16">
            <a href="{{route('allrooms')}}" class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-10 py-4 rounded-full hover:shadow-2xl transition-all duration-300 font-bold text-lg hover:scale-105">
                <span>Lihat Semua Fasilitas</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<script>
</script>



    <section class="py-16 px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 mb-10 text-center">Mengapa Memilih Pointer Hotel?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-blue-50/50 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Premium Service</h3>
                    <p class="text-gray-600">Experience luxury and comfort with our world-class amenities</p>
                </div>

                <div class="text-center p-6 bg-green-50/50 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Prime Location</h3>
                    <p class="text-gray-600">Strategically located in the heart of the city for easy access</p>
                </div>

                <div class="text-center p-6 bg-purple-50/50 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">24/7 Service</h3>
                    <p class="text-gray-600">Round-the-clock assistance to ensure your comfort and satisfaction</p>
                </div>
            </div>
        </div>
    </section>


<section id='about' class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        
        <div>
            <h2 class="text-4xl font-bold text-blue-600 mb-6">
                About <span class="text-gray-800">Pointer Hotel</span>
            </h2>
            <p class="text-gray-600 leading-relaxed mb-6">
                Welcome to Pointer Hotel - Your Trusted Hotel Booking Partner. 
                We make it easy to find and book the perfect stay whether for business or vacation. <br>
                Enjoy a seamless experience with handpicked hotels, great deals, and 24/7 support.
            </p>
            <a href="#rooms-section" 
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-medium transition shadow-md">
                Booking Now
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="relative">
            <img src="/resort.jpeg" alt="Hotel Image" class="rounded-2xl shadow-2xl w-full h-auto object-cover">
            <div class="absolute -top-6 -left-6 w-20 h-20 bg-blue-200 rounded-full -z-10 animate-float-delay-0"></div>
            <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-yellow-200 rounded-full -z-10 animate-float-delay-1000"></div>
        </div>
    </div>
</section>

<section 
    id="testimonial-section" 
    class="relative pt-24 pb-32 bg-gray-900 overflow-hidden" 
    x-data="{ 
        // Data dan Logika Alpine.js
        active: 0, 
        testimonials: [
            { name: 'Esther Hills', role: 'Traveller', avatar: 'https://i.pravatar.cc/150?img=1', rating: 5, quote: 'The villa we stayed in was straight out of a movie. Private beach access, gourmet meals, and a sunset massage — it was everything we hoped for.' },
            { name: 'Gary L. Hopper', role: 'Traveller', avatar: 'https://i.pravatar.cc/150?img=2', rating: 5, quote: 'Our kids loved the play area and pool while we enjoyed the hot tub suite. Plus, the complimentary breakfast had amazing variety!' },
            { name: 'Julia S. Lackey', role: 'Traveller', avatar: 'https://i.pravatar.cc/150?img=3', rating: 4, quote: 'From booking to checkout, everything felt like having a personal assistant. The ocean-view room was spacious and clean. Highly recommended.' },
            { name: 'Mike Johnson', role: 'Adventure Seeker', avatar: 'https://i.pravatar.cc/150?img=4', rating: 5, quote: 'Best trekking experience! The guide was knowledgeable and the basecamp facilities were excellent. Will definitely book again.' },
            { name: 'Sarah Chen', role: 'Family Trip', avatar: 'https://i.pravatar.cc/150?img=5', rating: 4, quote: 'The shuttle service was prompt, and the staff was extremely friendly. A very relaxing and hassle-free vacation for the whole family.' }
        ],
        // Logika untuk menentukan lebar tampilan (Jumlah Card Per Tampilan)
        itemsPerView() {
            if (window.innerWidth >= 1024) return 3; // lg: 3 card
            if (window.innerWidth >= 768) return 2;  // md: 2 card
            return 1; // default: 1 card
        },
        // Logika untuk menghitung batas maksimum geseran
        get maxOffset() {
            // Slider berhenti setelah menggeser card terakhir ke posisi awal.
            return this.testimonials.length - this.itemsPerView();
        },
        // Logika untuk menghitung persentase geseran (transform)
        get offsetPercentage() {
            // Misalnya: Jika 5 card dan 3 terlihat, total geseran yang dibutuhkan adalah 3 slot.
            // Geser aktif * (100% / Total Card)
            // Diperbaiki: Menggeser sejauh aktif * (Lebar 1 Card)
            return (this.active * 100) / this.testimonials.length;
        },
        prev() {
            this.active = Math.max(0, this.active - 1); 
        },
        next() {
            this.active = Math.min(this.maxOffset, this.active + 1);
        },
        // Inisialisasi dan listener untuk mengubah posisi active saat resize
        init() {
            window.addEventListener('resize', () => {
                // Saat ukuran layar berubah (misal: dari 3 kolom ke 2 kolom), 
                // pastikan posisi aktif tidak melebihi batas baru.
                if (this.active > this.maxOffset) {
                    this.active = Math.max(0, this.maxOffset);
                }
            });
        }
    }"
>
    <div 
        class="absolute inset-0 bg-cover bg-center transition-all duration-1000 h-full" 
        style="background-image: url('/resort.jpeg');"
    >
        <div class="absolute inset-0 bg-black opacity-60"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-16 pt-0">
            <div class="text-white max-w-xl mb-6">
                <p class="text-sm font-semibold uppercase tracking-widest text-yellow-500">
                    Client Testimonial
                </p>
                <h2 class="text-5xl md:text-6xl font-bold leading-tight mt-1">
                    What People Say <br>
                    <span class="text-gray-300">About Us</span>
                </h2>
                <p class="mt-3 text-gray-300 max-w-sm text-lg hidden md:block">
                    Explore hidden gems, local experiences, travel hacks, and destination stories.
                </p>
            </div>

            <div class="flex flex-col items-start lg:items-end">
                <div class="flex items-center space-x-2 text-yellow-500">
                    <div class="flex">
                        <template x-for="i in 4">
                            <svg class="w-6 h-6 fill-current text-yellow-500" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.487 7.07l6.561-.954L10 0l2.952 6.116 6.561.954-4.758 4.615 1.123 6.545z"/></svg>
                        </template>
                        <svg class="w-6 h-6 fill-current text-yellow-500" viewBox="0 0 20 20">
                            <defs>
                                <linearGradient id="halfGradient2">
                                    <stop offset="50%" stop-color="#FBBF24" />
                                    <stop offset="50%" stop-color="#D1D5DB" />
                                </linearGradient>
                            </defs>
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.487 7.07l6.561-.954L10 0l2.952 6.116 6.561.954-4.758 4.615 1.123 6.545z" fill="url(#halfGradient2)"/>
                        </svg>
                    </div>
                    <span class="text-lg text-gray-300 font-semibold">4.5/ 2k reviews</span>
                </div>
            </div>
        </div>
        
        <div class="text-white text-9xl font-extrabold opacity-10 absolute left-6 bottom-40 transform -translate-x-1/2 hidden lg:block">
            &rdquo;
        </div>
        
        <div class="relative overflow-hidden">
            <div 
                x-ref="carousel"
                class="flex transition-transform duration-500 ease-out -mx-4"
                :style="`transform: translateX(-${offsetPercentage}%)`"
            >
                <template x-for="(item, index) in testimonials" :key="index">
                    <div 
                        class="px-4 flex-shrink-0 w-full md:w-1/2 lg:w-1/3"
                    >
                        <div class="bg-white p-6 rounded-xl shadow-2xl h-full flex flex-col justify-between border-t-4 border-yellow-500 transform hover:scale-[1.02] transition-transform duration-300">
                            <p class="text-gray-700 text-lg italic mb-4 line-clamp-5" x-text="`&ldquo;${item.quote}&rdquo;`"></p>
                            
                            <div class="flex space-x-1 text-yellow-500 mb-4">
                                <template x-for="i in 5">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20" :class="{ 'text-gray-300': i > item.rating }"><path d="M10 15l-5.878 3.09 1.123-6.545L.487 7.07l6.561-.954L10 0l2.952 6.116 6.561.954-4.758 4.615 1.123 6.545z"/></svg>
                                </template>
                            </div>

                            <div class="flex items-center space-x-4 pt-4 border-t border-gray-100">
                                <img :src="item.avatar" alt="Avatar" class="w-12 h-12 rounded-full object-cover border-2 border-yellow-500">
                                <div>
                                    <p class="text-lg font-semibold text-gray-900" x-text="item.name"></p>
                                    <p class="text-sm text-gray-500" x-text="item.role"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex justify-start space-x-2 mt-8">
                <button 
                    @click="prev()" 
                    :disabled="active === 0"
                    class="bg-gray-700 text-white p-3 rounded-full hover:bg-yellow-500 transition duration-300 disabled:opacity-30 disabled:cursor-not-allowed"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button 
                    @click="next()" 
                    :disabled="active >= maxOffset"
                    class="bg-gray-700 text-white p-3 rounded-full hover:bg-yellow-500 transition duration-300 disabled:opacity-30 disabled:cursor-not-allowed"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

        </div>
        
    </div>
</section>

<footer class="bg-gray-900 text-white py-16">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center">
                        <img src="/pointer.png" alt="pointer">
                    </div>
                    <h3 class="text-2xl font-bold">Pointer Hotel</h3>
                </div>
                <p class="text-gray-400 mb-4">
                    Pengalaman menginap mewah dengan pelayanan terbaik di kelasnya.
                </p>
            </div>
            
            <div>
                <h4 class="font-bold text-lg mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="#home" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                    <li><a href="#rooms" class="text-gray-400 hover:text-white transition-colors">Rooms</a></li>
                    <li><a href="#facilities" class="text-gray-400 hover:text-white transition-colors">Facilities</a></li>
                    <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-bold text-lg mb-4">Contact Info</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>📧 info@pointerhotel.com</li>
                    <li>📞 +62 123 456 789</li>
                    <li>📍 Jakarta, Indonesia</li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-bold text-lg mb-4">Follow Us</h4>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700 cursor-pointer transition-colors">
                        <span class="text-white font-bold">f</span>
                    </a>
                    <a href="#" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center hover:bg-blue-500 cursor-pointer transition-colors">
                        <span class="text-white font-bold">t</span>
                    </a>
                    <a href="#" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700 cursor-pointer transition-colors">
                        <span class="text-white font-bold">i</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-12 pt-8 text-center">
            <p class="text-gray-400">&copy; 2024 Pointer Hotel. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
/* Animasi Float baru dengan delay */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); } /* Dibuat sedikit lebih kecil */
}

.animate-float-delay-0 {
    animation: float 6s ease-in-out infinite;
}
.animate-float-delay-1000 {
    animation: float 6s ease-in-out infinite;
    animation-delay: 1s;
}
/* Hapus class .animate-float dan .animation-delay-x */

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<script>
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById("mobile-menu-button");
    const menu = document.getElementById("mobile-menu");
    
    // Perbaikan: Toggle class 'hidden'
    btn.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });
    
    // Sembunyikan menu saat link diklik (agar lebih ramah pengguna)
    menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.add('hidden');
        });
    });
});


// Slider functionality for Facilities
class HotelSlider {
    constructor(sliderId, prevBtnId, nextBtnId, dotsId, itemSelector) {
        this.slider = document.getElementById(sliderId);
        this.prevBtn = document.getElementById(prevBtnId);
        this.nextBtn = document.getElementById(nextBtnId);
        this.dotsContainer = document.getElementById(dotsId);
        this.currentIndex = 0;
        this.itemSelector = itemSelector;
        this.itemWidth = 0;
        this.totalItems = this.slider ? this.slider.children.length : 0;
        this.itemsPerView = 1; 
        
        this.init();
    }
    
    // Hitung berapa banyak item yang terlihat (1/3 di lg, 1/2 di md, 1 di mobile)
    calculateItemsPerView() {
        if (window.innerWidth >= 1024) return 3; // lg
        if (window.innerWidth >= 768) return 2;  // md
        return 1; // mobile
    }
    
    init() {
        if (!this.slider) return;
        
        this.bindEvents();
        
        // Setup awal dan resize handler
        const setup = () => {
            this.itemsPerView = this.calculateItemsPerView();
            // Ambil lebar container, bagi dengan itemsPerView
            // Asumsi semua item memiliki lebar yang sama (min-w-1/3)
            this.itemWidth = this.slider.clientWidth / this.itemsPerView; 
            
            this.maxIndex = Math.max(0, this.totalItems - this.itemsPerView);
            this.currentIndex = Math.min(this.currentIndex, this.maxIndex);
            
            this.createDots();
            this.updateSlider();
        };

        setup(); // Initial setup
        window.addEventListener('resize', setup); // Handle resize
    }
    
    createDots() {
        if (!this.dotsContainer) return;
        this.dotsContainer.innerHTML = ''; // Hapus dots lama
        
        // Buat dot hanya untuk jumlah slide yang terlihat (maxIndex + 1)
        for (let i = 0; i <= this.maxIndex; i++) {
            const dot = document.createElement('button');
            dot.classList.add('w-3', 'h-3', 'rounded-full', 'transition-colors', 'duration-300');
            dot.classList.add(i === this.currentIndex ? 'bg-indigo-600' : 'bg-gray-400');
            dot.dataset.index = i;
            dot.addEventListener('click', () => this.goTo(i));
            this.dotsContainer.appendChild(dot);
        }
    }
    
    updateDots() {
        if (!this.dotsContainer) return;
        this.dotsContainer.querySelectorAll('button').forEach((dot, index) => {
            dot.classList.remove('bg-indigo-600', 'bg-gray-400');
            dot.classList.add(index === this.currentIndex ? 'bg-indigo-600' : 'bg-gray-400');
        });
    }

    updateSlider() {
        // Hati-hati dengan perhitungan di sini, pastikan itemWidth sudah terhitung benar
        const offset = this.currentIndex * this.itemWidth;
        this.slider.style.transform = `translateX(-${offset}px)`;
        this.updateDots();
    }

    goTo(index) {
        this.currentIndex = Math.min(Math.max(0, index), this.maxIndex);
        this.updateSlider();
    }
    
    bindEvents() {
        this.prevBtn.addEventListener('click', () => this.goTo(this.currentIndex - 1));
        this.nextBtn.addEventListener('click', () => this.goTo(this.currentIndex + 1));
    }
}

// Inisialisasi Slider Fasilitas
document.addEventListener('DOMContentLoaded', () => {
    // Pastikan DOM sudah dimuat sebelum inisialisasi slider
    new HotelSlider(
        'facilities-slider', 
        'facilities-prev', 
        'facilities-next', 
        'facilities-dots', 
        '.flex-shrink-0'
    );
});
</script>
@endsection