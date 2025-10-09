@extends('layouts.app')

@section('title', 'Booking Fasilitas')

@section('content')

<div class="min-h-screen py-12 px-4 mt-20">
    <div class="max-w-4xl mx-auto">
        
        {{-- X-DATA: Kelola Kapasitas Tamu (Dewasa/Anak) dan Add-ons --}}
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden" 

             x-data="{ 
                 selectedFasilitas: [], // Digunakan untuk ID fasilitas utama yang dipilih
                 // MEMPERBAIKI: Menggunakan $fasilitasUtama
                 fasilitasData: JSON.parse('{!! e(json_encode($fasilitasUtama->pluck('max_adults', 'id'))) !!}'),
                 anakData: JSON.parse('{!! e(json_encode($fasilitasUtama->pluck('max_children', 'id'))) !!}'),
                 totalMaxDewasa: 0,
                 totalMaxAnak: 0,
                 // Data Add-ons untuk pelacakan kuantitas
                 selectedAddons: JSON.parse('{!! json_encode(old('addon_quantity', [])) !!}'),

                 init() {
                     // Inisialisasi dengan fasilitas default
                     // MEMPERBAIKI: Menggunakan $selectedFasilitas
                     @if($selectedFasilitas)
                         this.selectedFasilitas.push('{{ $selectedFasilitas->id }}');
                     @endif
                     this.updateMaxGuests();
                 },
                 
                 // Logika untuk menghitung total kapasitas tamu dari fasilitas yang dipilih
                 updateMaxGuests() {
                     let tempMaxDewasa = 0;
                     let tempMaxAnak = 0;

                     this.selectedFasilitas.forEach(id => {
                         id = parseInt(id);
                         // Gunakan data dari fasilitas yang dipilih, jika tidak ada fallback ke default (misal: 2 dewasa, 1 anak)
                         tempMaxDewasa += (this.fasilitasData[id] || 2);
                         tempMaxAnak += (this.anakData[id] || 1); 
                     });

                     // Jika tidak ada yang dipilih (misal user membatalkan pilihan fasilitas default), set ke 0
                     if (this.selectedFasilitas.length === 0) {
                        tempMaxDewasa = 0;
                        tempMaxAnak = 0;
                     }
                     
                     this.totalMaxDewasa = tempMaxDewasa;
                     this.totalMaxAnak = tempMaxAnak;

                     // Set value input Dewasa dan Anak saat ada perubahan
                     this.$nextTick(() => {
                        this.$refs.inputDewasa.value = this.totalMaxDewasa;
                        this.$refs.inputAnak.value = this.totalMaxAnak;
                     });
                 }
             }" 
             x-init="init()"> 
            
            {{-- Form Booking --}}
            <form action="{{ route('booking.storefasilitas') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="p-8">
                    
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-4">
                        Konfirmasi Pemesanan Fasilitas
                    </h2>

                    {{-- SECTION: FASILITAS UTAMA TERPILIH --}}
                    {{-- MEMPERBAIKI: Menggunakan $selectedFasilitas --}}
                    @if($selectedFasilitas)
                        <input type="hidden" name="fasilitas_ids[]" value="{{ $selectedFasilitas->id }}">
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8 shadow-inner">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-semibold text-blue-800 mb-1">Fasilitas Utama Terpilih</h3>
                                    <p class="text-blue-700 font-medium text-2xl">{{ $selectedFasilitas->name }}</p>
                                    <p class="text-blue-600 text-sm mt-1">
                                        Max: {{ $selectedFasilitas->max_adults }} Dewasa, {{ $selectedFasilitas->max_children }} Anak
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-blue-800">Rp {{ number_format($selectedFasilitas->price, 0, ',', '.') }}</p>
                                    <p class="text-blue-600 text-sm">per malam</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    {{-- SECTION: PILIH FASILITAS LAIN --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Tambahkan Fasilitas Lain</h3>
                        <div class="flex space-x-4 pb-4 overflow-x-scroll scrolling-touch">
                            {{-- MEMPERBAIKI: Menggunakan $fasilitasUtama dan loop $fasilitas --}}
                            @foreach($fasilitasUtama as $fasilitas)
                                @php
                                    $isFull = false; 
                                    $alreadySelected = $selectedFasilitas && $selectedFasilitas->id === $fasilitas->id;
                                @endphp
                                @if(!$alreadySelected)
                                <div class="w-64 flex-shrink-0"> 
                                    <div class="group rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden bg-white border border-gray-100">
                                        <div class="relative overflow-hidden">
                                            <img src="{{ $fasilitas->image ?? asset('images/default-room.jpg') }}" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-700">
                                            @if($isFull)
                                                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Penuh</span>
                                            @else
                                                <span class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Tersedia</span>
                                            @endif
                                        </div>
                                        <div class="p-3">
                                            <h4 class="font-bold text-gray-900 truncate">{{ $fasilitas->name }}</h4>
                                            <p class="text-blue-600 font-semibold mt-1 mb-2 text-sm">Rp {{ number_format($fasilitas->price,0,',','.') }}/malam</p>
                                            <p class="text-gray-500 text-xs mb-2">Maks: {{ $fasilitas->max_adults }} Dewasa, {{ $fasilitas->max_children }} Anak</p> 
                                            
                                            <label class="flex items-center space-x-2">
                                                <input type="checkbox" name="fasilitas_ids[]" value="{{ $fasilitas->id }}" 
                                                    @if($isFull) disabled @endif
                                                    x-model="selectedFasilitas" 
                                                    @change="updateMaxGuests()"
                                                    class="h-4 w-4 text-blue-600 rounded">
                                                <span class="text-xs">Pilih Fasilitas Ini</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <hr class="my-8">

                    {{-- SECTION: JUMLAH TAMU (FIXED) --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <h3 class="md:col-span-2 text-xl font-semibold text-gray-800 mb-2">Detail Tamu</h3>

                        {{-- Field Dewasa (FIX DARI KAPASITAS KAMAR) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="dewasa">
                                Jumlah Dewasa 
                                <span class="text-xs text-red-500" x-text="'(Max: ' + totalMaxDewasa + ')'"></span>
                            </label>
                            <input type="number" name="dewasa" id="dewasa" 
                                x-ref="inputDewasa"
                                :value="totalMaxDewasa"
                                min="1" 
                                readonly 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" required>
                            <p class="text-xs text-gray-500 mt-1">Jumlah total dewasa (Otomatis dari fasilitas yang dipilih).</p>
                        </div>
                        
                        {{-- Field Anak (FIX DARI KAPASITAS KAMAR) --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="anak">
                                Jumlah Anak 
                                <span class="text-xs text-red-500" x-text="'(Max: ' + totalMaxAnak + ')'"></span>
                            </label>
                            <input type="number" name="anak" id="anak" 
                                x-ref="inputAnak"
                                :value="totalMaxAnak"
                                min="0" 
                                readonly 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" required>
                            <p class="text-xs text-gray-500 mt-1">Jumlah total anak (Otomatis dari fasilitas yang dipilih).</p>
                        </div>
                        @error('fasilitas_ids') <p class="text-red-500 text-xs mt-1 md:col-span-2">{{ $message }}</p> @enderror
                    </div>

                    <hr class="my-8">

                    {{-- SECTION: PILIH ADD-ONS TAMBAHAN --}}
                    @if(isset($addons) && $addons->count() > 0)
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                Pilih Fasilitas Tambahan (Add-ons) 🍽️
                                <span class="ml-3 text-sm font-normal text-gray-500">(Opsional, Per-pesanan)</span>
                            </h3>
                            
                            <div class="grid md:grid-cols-3 gap-6">
                                @foreach($addons as $addon)
                                    @php
                                        // Asumsi icon_class ada, atau gunakan default
                                        $iconClass = $addon->icon_class ?? 'fas fa-plus-circle'; 
                                        // Ambil old value dari addon_quantity
                                        $oldQuantity = old("addon_quantity.{$addon->id}", 0); 
                                        // Cek apakah addon ini harusnya tercentang (dari old value atau default)
                                        $isChecked = in_array($addon->id, old('addons', [])) || ($oldQuantity > 0);
                                    @endphp

                                    <label for="addon_{{ $addon->id }}" 
                                        class="block cursor-pointer transition-all duration-300 rounded-xl border"
                                        :class="{ 
                                            'bg-blue-50 border-blue-500 ring-2 ring-blue-300 shadow-lg': selectedAddons['{{ $addon->id }}'] > 0, 
                                            'bg-white border-gray-200 hover:shadow-md': selectedAddons['{{ $addon->id }}'] == 0 
                                        }">
                                        <div class="p-4 h-full flex flex-col justify-between">
                                            
                                            {{-- Header / Info Add-on --}}
                                            <div class="flex items-center space-x-4 mb-4">
                                                {{-- Ikon Fasilitas (Ganti dengan Heroicons/Font Awesome jika Anda menggunakannya) --}}
                                                <div class="text-blue-600 p-3 bg-blue-100 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-gray-900">{{ $addon->name }}</h4>
                                                    <p class="text-sm font-semibold text-blue-600">
                                                        Rp {{ number_format($addon->price, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Checkbox dan Quantity --}}
                                            <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100">
                                                
                                                {{-- Checkbox --}}
                                                <input type="checkbox" name="addons[]" id="addon_{{ $addon->id }}" value="{{ $addon->id }}" 
                                                    @if($isChecked) checked @endif
                                                    @change="
                                                        if ($event.target.checked) { 
                                                            selectedAddons['{{ $addon->id }}'] = selectedAddons['{{ $addon->id }}'] > 0 ? selectedAddons['{{ $addon->id }}'] : 1;
                                                        } else {
                                                            selectedAddons['{{ $addon->id }}'] = 0; 
                                                        }
                                                    "
                                                    class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500 flex-shrink-0">
                                                
                                                {{-- Input Quantity --}}
                                                <div class="flex items-center" x-show="selectedAddons['{{ $addon->id }}'] > 0">
                                                    <label for="addon_qty_{{ $addon->id }}" class="text-sm font-medium text-gray-700 mr-2">Qty:</label>
                                                    <input type="number" 
                                                        name="addon_quantity[{{ $addon->id }}]" 
                                                        id="addon_qty_{{ $addon->id }}" 
                                                        min="1" 
                                                        value="{{ $oldQuantity > 0 ? $oldQuantity : 1 }}" 
                                                        @input="selectedAddons['{{ $addon->id }}'] = $event.target.value"
                                                        placeholder="1"
                                                        class="w-16 px-2 py-1 border border-gray-300 rounded-lg text-center text-sm focus:ring-blue-500 focus:border-blue-500">
                                                </div>

                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <hr class="my-8">
                    
                    {{-- SECTION: TANGGAL & WAKTU --}}
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Waktu Pemesanan</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Check-in Date</label>
                            <input type="date" name="check_in" value="{{ old('check_in', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            @error('check_in') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Check-out Date</label>
                            <input type="date" name="check_out" value="{{ old('check_out', date('Y-m-d', strtotime('+1 day')))}}" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            @error('check_out') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Arrival Time</label>
                            <input type="time" name="arrival_time" value="{{ old('arrival_time') ?? '14:00' }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            @error('arrival_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <hr class="my-8">

                    {{-- SECTION: DATA PEMESANAN & TAMU --}}
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Data Pemesan & Tamu</h3>
                    <div class="space-y-6">
                        {{-- Data Pemesan (Otomatis dari Auth) --}}
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemesan</label>
                                <input type="text" name="pemesan_display" value="{{ Auth::user()->Name }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                                <input type="hidden" name="pemesan" value="{{ Auth::user()->Name }}">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Pemesan</label>
                                <input type="email" name="Email" value="{{ Auth::user()->email }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                            <input type="tel" name="Phone" value="{{ old('Phone', Auth::user()->phone ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            @error('Phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Tamu Utama <span class="text-red-500">*</span></label>
                            <textarea name="Nama_Tamu" rows="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Masukkan nama tamu utama yang akan check-in" required>{{ old('Nama_Tamu') }}</textarea>
                            @error('Nama_Tamu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <hr class="my-8">

                    {{-- SECTION: REQUESTS & TERMS --}}
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Special Requests (Optional)</label>
                            <textarea name="Special_Request" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg"
                                            placeholder="Any special requests or notes for your stay...">{{ old('Special_Request') }}</textarea>
                            @error('Special_Request') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="agree_terms" id="agree_terms" class="mt-1 h-5 w-5 text-blue-600 rounded" required>
                            <label for="agree_terms" class="text-sm text-gray-600">
                                I agree to the 
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline">Terms and Conditions</a> 
                                and 
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline">Privacy Policy</a>
                            </label>
                            @error('agree_terms') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-6 border-t border-gray-200 flex justify-end">
                            <button type="submit"
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-200 font-semibold shadow-lg">
                                Confirm Booking
                            </button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
@endsection
