@extends('layouts.app')

@section('title', 'Pointer Hotel - Find Your Perfect Stay')

@section('content')

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


<!-- Filter & Search Section -->
<section class="container mx-auto px-6 py-8 -mt-8 relative z-10">
    <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Search Bar -->
            <div class="lg:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Kamar
                </label>
                <input 
                    type="text" 
                    id="search-input" 
                    placeholder="Cari nama atau deskripsi kamar..." 
                    class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                >
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Status
                </label>
                <select id="filter-status" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="all">Semua Status</option>
                    <option value="available">✅ Tersedia</option>
                    <option value="full">🚫 Penuh</option>
                </select>
            </div>

            <!-- Sort Price -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                    Urutkan
                </label>
                <select id="sort-price" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    <option value="default">Default</option>
                    <option value="asc">💰 Termurah</option>
                    <option value="desc">💎 Termahal</option>
                    <option value="name-asc">🔤 A-Z</option>
                    <option value="name-desc">🔤 Z-A</option>
                </select>
            </div>
        </div>

        <!-- Filter Tags & Reset -->
        <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap gap-2" id="active-filters">
                <!-- Active filters will appear here -->
            </div>
            <button id="reset-btn" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-xl transition-all font-semibold flex items-center gap-2 shadow-md hover:shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Reset Filter
            </button>
        </div>

        <!-- Results Counter -->
        <div class="mt-4">
            <p id="results-counter" class="text-sm font-semibold text-gray-600"></p>
        </div>
    </div>
</section>

<!-- Rooms Grid Section -->
<section class="container mx-auto px-6 py-10">
    <div id="rooms-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($kamars as $kamar)
            @php
                $activeDetailBookings = $kamar->detailBookings()->whereHas('booking', function ($query) { 
                    $query->whereIn('status', ['diproses', 'checkin']);
                })->count();
                $isFull = $activeDetailBookings >= $kamar->jumlah; 
            @endphp

            <div class="room-card bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-gray-100" 
                 data-status="{{ $isFull ? 'full' : 'available' }}"
                 data-price="{{ $kamar->price }}"
                 data-name="{{ strtolower($kamar->name) }}"
                 data-description="{{ strtolower($kamar->description) }}">
                
                <div class="relative overflow-hidden group">
                    <img src="{{ $kamar->image }}" class="w-full h-72 object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $kamar->name }}">
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
                        {{ $kamar->jumlah - $activeDetailBookings }}/{{ $kamar->jumlah }} Kamar
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-3 text-gray-900">{{ $kamar->name }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">{{ $kamar->description }}</p>
                    
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
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            TV
                        </span>
                    </div>

                    <div class="border-t pt-4">
                        <p class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 font-extrabold text-3xl mb-4">
                            Rp {{ number_format($kamar->price, 0, ',', '.') }}
                            <span class="text-sm text-gray-500 font-normal">/malam</span>
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
                                <a href="{{ route('booking.create', ['kamar_id' => $kamar->id]) }}" 
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
        @endforeach
    </div>

    <!-- No Results Message -->
    <div id="no-results" class="hidden text-center py-20">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-2xl font-bold text-gray-700 mb-2">Tidak Ada Kamar Ditemukan</h3>
        <p class="text-gray-500 mb-6">Coba ubah filter atau kata kunci pencarian Anda</p>
        <button id="reset-no-results" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
            Reset Pencarian
        </button>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const filterStatus = document.getElementById('filter-status');
    const sortPrice = document.getElementById('sort-price');
    const resetBtn = document.getElementById('reset-btn');
    const roomsGrid = document.getElementById('rooms-grid');
    const noResults = document.getElementById('no-results');
    const resultsCounter = document.getElementById('results-counter');
    const activeFilters = document.getElementById('active-filters');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilter = filterStatus.value;
        const sortOption = sortPrice.value;

        // Get all room cards
        let rooms = Array.from(document.querySelectorAll('.room-card'));
        let visibleCount = 0;

        // Filter rooms
        rooms.forEach(room => {
            const name = room.getAttribute('data-name');
            const description = room.getAttribute('data-description');
            const status = room.getAttribute('data-status');

            const matchSearch = name.includes(searchTerm) || description.includes(searchTerm);
            const matchStatus = statusFilter === 'all' || status === statusFilter;

            if (matchSearch && matchStatus) {
                room.style.display = '';
                visibleCount++;
            } else {
                room.style.display = 'none';
            }
        });

        // Sort rooms
        const visibleRooms = rooms.filter(room => room.style.display !== 'none');
        
        if (sortOption === 'asc') {
            visibleRooms.sort((a, b) => {
                return parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price'));
            });
        } else if (sortOption === 'desc') {
            visibleRooms.sort((a, b) => {
                return parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price'));
            });
        } else if (sortOption === 'name-asc') {
            visibleRooms.sort((a, b) => {
                return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
            });
        } else if (sortOption === 'name-desc') {
            visibleRooms.sort((a, b) => {
                return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
            });
        }

        // Reorder DOM elements
        visibleRooms.forEach(room => {
            roomsGrid.appendChild(room);
        });

        // Update results counter
        const availableCount = visibleRooms.filter(r => r.getAttribute('data-status') === 'available').length;
        const fullCount = visibleRooms.filter(r => r.getAttribute('data-status') === 'full').length;
        
        resultsCounter.innerHTML = `
            Menampilkan <strong>${visibleCount}</strong> kamar 
            (<span class="text-green-600">${availableCount} tersedia</span>, 
            <span class="text-red-600">${fullCount} penuh</span>)
        `;

        // Show/hide no results
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            roomsGrid.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            roomsGrid.classList.remove('hidden');
        }

        updateActiveFilters();
    }

    function updateActiveFilters() {
        const filters = [];
        
        if (searchInput.value) {
            filters.push(`Pencarian: "${searchInput.value}"`);
        }
        if (filterStatus.value !== 'all') {
            filters.push(`Status: ${filterStatus.value === 'available' ? 'Tersedia' : 'Penuh'}`);
        }
        if (sortPrice.value !== 'default') {
            const sortLabels = {
                'asc': 'Harga Termurah',
                'desc': 'Harga Termahal',
                'name-asc': 'Nama A-Z',
                'name-desc': 'Nama Z-A'
            };
            filters.push(`Urutan: ${sortLabels[sortPrice.value]}`);
        }

        activeFilters.innerHTML = filters.map(filter => `
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                ${filter}
            </span>
        `).join('');
    }

    function resetFilters() {
        searchInput.value = '';
        filterStatus.value = 'all';
        sortPrice.value = 'default';
        applyFilters();
    }

    // Event listeners
    searchInput.addEventListener('input', applyFilters);
    filterStatus.addEventListener('change', applyFilters);
    sortPrice.addEventListener('change', applyFilters);
    resetBtn.addEventListener('click', resetFilters);
    document.getElementById('reset-no-results').addEventListener('click', resetFilters);

    // Initial load
    applyFilters();
});
</script>