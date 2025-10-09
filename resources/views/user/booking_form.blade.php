@extends('layouts.app')

@section('title', 'Hotel Booking')

@section('content')

@php
    // ✅ PERBAIKAN: Gabungkan data kamar dan anak untuk Alpine.js
    $allKamarData = $kamars->pluck('max_adults', 'id')->toArray();
    $allAnakData = $kamars->pluck('max_children', 'id')->toArray();
    
    if ($selectedKamar) {
        $allKamarData[$selectedKamar->id] = $selectedKamar->max_adults;
        $allAnakData[$selectedKamar->id] = $selectedKamar->max_children;
    }
@endphp

<div class="min-h-screen py-12 px-4 mt-20">
    <div class="max-w-4xl mx-auto">
        
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden" 
            x-data="{ 
                selectedKamars: [],
                totalMaxDewasa: {{ $selectedKamar ? $selectedKamar->max_adults : 2 }},
                totalMaxAnak: {{ $selectedKamar ? $selectedKamar->max_children : 1 }},
                
                inputDewasa: {{ $selectedKamar ? $selectedKamar->max_adults : 2 }},
                inputAnak: {{ $selectedKamar ? $selectedKamar->max_children : 1 }},
                
                // ✅ PERBAIKAN: Data kamar yang sudah digabungkan
                kamarData: JSON.parse('{!! e(json_encode($allKamarData)) !!}'),
                anakData: JSON.parse('{!! e(json_encode($allAnakData)) !!}'),
                
                init() {
                    @if($selectedKamar)
                        this.selectedKamars.push('{{ $selectedKamar->id }}');
                    @endif
                    this.updateMaxGuests();
                },
                
                updateMaxGuests() {
                    let tempMaxDewasa = 0;
                    let tempMaxAnak = 0;

                    this.selectedKamars.forEach(kamarId => {
                        kamarId = parseInt(kamarId);
                        // ✅ PERBAIKAN: Logika lebih sederhana
                        tempMaxDewasa += (this.kamarData[kamarId] || 0); 
                        tempMaxAnak += (this.anakData[kamarId] || 0); 
                    });

                    // Update max total
                    this.totalMaxDewasa = tempMaxDewasa;
                    this.totalMaxAnak = tempMaxAnak;
                    
                    // Atur ulang nilai input manual agar tidak melebihi batas baru
                    this.inputDewasa = Math.min(this.inputDewasa, this.totalMaxDewasa);
                    this.inputAnak = Math.min(this.inputAnak, this.totalMaxAnak);
                    
                    // Pastikan input minimal 1 dewasa
                    if (this.inputDewasa < 1 && this.totalMaxDewasa > 0) {
                        this.inputDewasa = 1;
                    }
                    if (this.totalMaxDewasa === 0) {
                        this.inputDewasa = 0;
                    }
                },
                
                enforceMax(type) {
                    this.$nextTick(() => {
                        if (type === 'dewasa') {
                            if (this.inputDewasa > this.totalMaxDewasa) {
                                this.inputDewasa = this.totalMaxDewasa;
                            }
                            if (this.inputDewasa < 1 && this.totalMaxDewasa > 0) {
                                this.inputDewasa = 1;
                            }
                        } else if (type === 'anak') {
                            if (this.inputAnak > this.totalMaxAnak) {
                                this.inputAnak = this.totalMaxAnak;
                            }
                            if (this.inputAnak < 0) {
                                this.inputAnak = 0;
                            }
                        }
                    });
                }

            }" 
            x-init="init()"> 
            
            <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="p-8">
                    
                    {{-- Kamar Default --}}
                    @if($selectedKamar)
                        {{-- HANYA INPUT HIDDEN: Kamar default hanya dikirimkan sekali di sini --}}
                        <input type="hidden" name="kamar_ids[]" value="{{ $selectedKamar->id }}"> 
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                            {{-- ... (Tampilan Kamar Terpilih) ... --}}
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Kamar Terpilih (Default)</h3>
                                    <p class="text-blue-700 font-medium text-xl">{{ $selectedKamar->name }}</p>
                                    <p class="text-blue-600">Max: {{ $selectedKamar->max_adults }} Dewasa, {{ $selectedKamar->max_children }} Anak</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-blue-800">Rp {{ number_format($selectedKamar->price, 0, ',', '.') }}</p>
                                    <p class="text-blue-600 text-sm">per night</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    {{-- SECTION: PILIH KAMAR LAIN --}}
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Pilih Kamar Lain</h3>
                        <div class="flex space-x-4 pb-4 overflow-x-scroll scrolling-touch">
                            @foreach($kamars as $kamar)
                                @php
                                    $isFull = false; 
                                    $alreadySelected = $selectedKamar && $selectedKamar->id === $kamar->id;
                                @endphp
                                
                                {{-- 🛑 Opsi 1: Skip Kamar Default di daftar kamar lain --}}
                                @continue($alreadySelected) 
                                
                                <div class="w-64 flex-shrink-0"> 
                                    <div class="group rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden bg-white border border-gray-100">
                                        {{-- ... (Image & Info Kamar) ... --}}
                                        <div class="relative overflow-hidden">
                                            <img src="{{ $kamar->image }}" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-700">
                                            @if($isFull)
                                                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">Penuh</span>
                                            @else
                                                <span class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">Tersedia</span>
                                            @endif
                                        </div>
                                        <div class="p-3">
                                            <h4 class="font-bold text-gray-900 truncate">{{ $kamar->name }}</h4>
                                            <p class="text-blue-600 font-semibold mt-1 mb-2 text-sm">Rp {{ number_format($kamar->price,0,',','.') }}/malam</p>
                                            <p class="text-gray-500 text-xs mb-2">Maks: {{ $kamar->max_adults }} Dewasa, {{ $kamar->max_children }} Anak</p> 
                                            
                                            <label class="flex items-center space-x-2">
                                                {{-- Checkbox untuk kamar tambahan --}}
                                                <input type="checkbox" name="kamar_ids[]" value="{{ $kamar->id }}" 
                                                    @if($isFull) disabled @endif
                                                    @change="
                                                        if ($event.target.checked) {
                                                            selectedKamars.push($event.target.value);
                                                        } else {
                                                            selectedKamars = selectedKamars.filter(id => id !== $event.target.value);
                                                        }
                                                        updateMaxGuests(); 
                                                    "
                                                    class="h-4 w-4 text-blue-600 rounded">
                                                
                                                @if($isFull)
                                                    <span class="text-xs text-red-600">Penuh</span>
                                                @else
                                                    <span class="text-xs">Pilih Kamar</span>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SECTION: INPUT DEWASA & ANAK --}}
                    <div class="grid md:grid-cols-2 gap-6 pt-6 border-t border-gray-200 mt-8">
                        
                        {{-- Field Dewasa --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="dewasa">
                                Jumlah Dewasa 
                                <span class="text-xs text-blue-500" x-text="'(Maks: ' + totalMaxDewasa + ')'"></span>
                            </label>
                            <input type="number" name="dewasa" id="dewasa" 
                                x-model.number="inputDewasa"
                                :min="totalMaxDewasa > 0 ? 1 : 0" 
                                :max="totalMaxDewasa"
                                x-on:input="enforceMax('dewasa')"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            <p class="text-xs text-gray-500 mt-1">Isi jumlah dewasa (dibatasi oleh total kapasitas kamar yang dipilih).</p>
                        </div>
                        
                        {{-- Field Anak --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="anak">
                                Jumlah Anak 
                                <span class="text-xs text-blue-500" x-text="'(Maks: ' + totalMaxAnak + ')'"></span>
                            </label>
                            <input type="number" name="anak" id="anak" 
                                x-model.number="inputAnak"
                                min="0" 
                                :max="totalMaxAnak"
                                x-on:input="enforceMax('anak')"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            <p class="text-xs text-gray-500 mt-1">Isi jumlah anak (dibatasi oleh total kapasitas kamar yang dipilih).</p>
                        </div>
                    </div>
                    
                  @if(isset($addons) && $addons->count() > 0)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                Pilih Add-ons Tambahan
                                <span class="ml-3 text-sm font-normal text-gray-500">(Opsional)</span>
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($addons as $addon)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 flex justify-between items-center transition-all duration-300 hover:shadow-md">
                                        <div class="flex items-center space-x-3 w-3/5">
                                            <input type="checkbox" name="addons[]" id="addon_{{ $addon->id }}" value="{{ $addon->id }}" 
                                                    class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 flex-shrink-0">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $addon->name }}</p>
                                                <p class="text-sm text-gray-500">Rp {{ number_format($addon->price, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="w-2/5 flex items-center justify-end">
                                            <label for="addon_qty_{{ $addon->id }}" class="text-sm font-medium text-gray-700 mr-2">Qty:</label>
                                            <input type="number" 
                                                    name="addon_quantity[{{ $addon->id }}]" 
                                                    id="addon_qty_{{ $addon->id }}" 
                                                    min="1" 
                                                    value="1" 
                                                    placeholder="1"
                                                    class="w-16 px-2 py-1 border border-gray-300 rounded-lg text-center text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    {{-- SECTION: DATA PEMESANAN & TAMU (tetap) --}}
                    <div class="space-y-6 pt-6 border-t border-gray-200">
                        {{-- ... (Konten Data Pemesanan tetap sama) ... --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemesan</label>
                            <input type="text" name="pemesan" value="{{ Auth::user()->Name }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Pemesan</label>
                            <input type="email" name="Email" value="{{ Auth::user()->email }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="Phone" value="{{ old('Phone', Auth::user()->phone ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            @error('Phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Tamu Utama</label>
                            <textarea name="Nama_Tamu" rows="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Masukkan nama tamu utama, misalnya: Budi Santoso" required>{{ old('Nama_Tamu') }}</textarea>
                            @error('Nama_Tamu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- SECTION: TANGGAL & WAKTU (tetap) --}}
                    <div class="grid md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                        {{-- ... (Konten Tanggal & Waktu tetap sama) ... --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Check-in Date</label>
                            <input type="date" name="check_in" value="{{ old('check_in') }}" min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            @error('check_in') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Check-out Date</label>
                            <input type="date" name="check_out" value="{{ old('check_out') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            @error('check_out') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Arrival Time</label>
                            <input type="time" name="arrival_time" value="{{ old('arrival_time') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg" required>
                            @error('arrival_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- SECTION: REQUESTS & TERMS (tetap) --}}
                    <div class="space-y-6 pt-6 border-t border-gray-200">
                        {{-- ... (Konten Requests & Terms tetap sama) ... --}}
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