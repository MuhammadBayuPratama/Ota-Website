@extends('layouts.app_admin')

@section('title', 'Booking Management')

@section('content')
<div x-data="{ tab: 'kamar' }" class="max-w-7xl mx-auto mt-8 px-4 ml-60">

    {{-- Session Messages --}}
    @if(session('success'))
        <div class="p-3 mb-4 bg-green-200 text-green-800 rounded shadow">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 mb-4 bg-red-200 text-red-800 rounded shadow">{{ session('error') }}</div>
    @endif

    {{-- Tabs --}}
    <div class="flex space-x-2 mb-6 overflow-x-auto">
        <button 
            :class="tab === 'kamar' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
            class="px-4 py-2 rounded font-semibold transition-colors duration-200 whitespace-nowrap"
            @click="tab = 'kamar'">Booking Kamar</button>

        <button 
            :class="tab === 'fasilitas' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
            class="px-4 py-2 rounded font-semibold transition-colors duration-200 whitespace-nowrap"
            @click="tab = 'fasilitas'">Booking Fasilitas</button>
    </div>

    {{-- Booking Kamar --}}
    <div x-show="tab === 'kamar'" x-transition.opacity.duration.500ms>
        @if($bookingsKamar->isEmpty())
            <p class="text-gray-600">Belum ada booking kamar.</p>
        @else
            <ul class="space-y-4">
                @foreach($bookingsKamar as $b)
                    <li class="p-4 border rounded bg-white shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200">
                        <div class="flex justify-between items-center flex-wrap gap-3">
                            <div>
                                <strong class="text-lg">{{ $b->kamar->Name ?? '—' }}</strong>
                                <div class="text-sm text-gray-600 mt-1">
                                    User: {{ $b->user->Name }} <br>
                                    Check-in: {{ $b->check_in }} — Check-out: {{ $b->check_out }} <br>
                                    Durasi: {{ $b->durasi }} hari — Rp {{ number_format($b->total_harga,0,',','.') }}
                                </div>
                            </div>

                            <div class="flex items-center gap-2 flex-wrap">
                                {{-- Status Label --}}
                                <span class="px-2 py-1 rounded text-sm font-medium
                                    @if($b->status=='diproses') bg-yellow-200 text-yellow-800
                                    @elseif($b->status=='checkin') bg-indigo-500 text-white
                                    @elseif($b->status=='checkout') bg-purple-500 text-white
                                    @elseif($b->status=='selesai') bg-green-500 text-white
                                    @elseif($b->status=='maintenance') bg-orange-500 text-white
                                    @elseif($b->status=='pending_cancel') bg-pink-500 text-white
                                    @elseif($b->status=='cancelled') bg-red-500 text-white
                                    @endif">{{ ucfirst($b->status) }}</span>

                                {{-- Actions --}}
                                @if($b->status=='diproses')
                                    <form action="{{ route('admin.booking.checkin', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-blue-500 hover:bg-blue-600">Check-in</button>
                                    </form>
                                @elseif($b->status=='checkin')
                                    <form action="{{ route('admin.booking.checkout', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-indigo-500 hover:bg-indigo-600">Check-out</button>
                                    </form>
                                @elseif($b->status=='checkout')
                                    <form action="{{ route('admin.booking.selesai.kamar', $b->id) }}" method="POST" onsubmit="return confirm('Tandai sebagai selesai?')">@csrf
                                        <button class="btn-action bg-green-500 hover:bg-green-600">Selesai</button>
                                    </form>
                                @elseif($b->status=='selesai')
                                    <form action="{{ route('admin.booking.maintenance.kamar', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-orange-500 hover:bg-orange-600">Maintenance</button>
                                    </form>
                                @elseif($b->status=='maintenance')
                                    <form action="{{ route('admin.booking.maintenance.done.kamar', $b->id) }}" method="POST" onsubmit="return confirm('Selesai maintenance?')">@csrf
                                        <button class="btn-action bg-green-500 hover:bg-green-600">Done</button>
                                    </form>
                                @endif

                                {{-- Cancel Request --}}
                                @if($b->status=='pending_cancel')
                                    <form action="{{ route('admin.booking.cancel.approve', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-green-500 hover:bg-green-600">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.booking.cancel.reject', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-red-500 hover:bg-red-600">Reject</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Booking Fasilitas --}}
    <div x-show="tab === 'fasilitas'" x-transition.opacity.duration.500ms x-cloak>
        @if($bookingsFasilitas->isEmpty())
            <p class="text-gray-600">Belum ada booking fasilitas.</p>
        @else
            <ul class="space-y-4">
                @foreach($bookingsFasilitas as $b)
                    <li class="p-4 border rounded bg-white shadow-sm hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200">
                        <div class="flex justify-between items-center flex-wrap gap-3">
                            <div>
                                <strong class="text-lg">{{ $b->fasilitas->name ?? '—' }}</strong>
                                <div class="text-sm text-gray-600 mt-1">
                                    User: {{ $b->user->name }} <br>
                                    Check-in: {{ $b->check_in }} — Check-out: {{ $b->check_out }} <br>
                                    Durasi: {{ $b->durasi }} hari — Rp {{ number_format($b->total_harga,0,',','.') }}
                                </div>
                            </div>

                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-2 py-1 rounded text-sm font-medium
                                    @if($b->status=='diproses') bg-yellow-200 text-yellow-800
                                    @elseif($b->status=='checkin') bg-indigo-500 text-white
                                    @elseif($b->status=='checkout') bg-purple-500 text-white
                                    @elseif($b->status=='selesai') bg-green-500 text-white
                                    @elseif($b->status=='maintenance') bg-orange-500 text-white
                                    @elseif($b->status=='pending_cancel') bg-pink-500 text-white
                                    @elseif($b->status=='cancelled') bg-red-500 text-white
                                    @endif">{{ ucfirst($b->status) }}</span>

                                @if($b->status=='diproses')
                                    <form action="{{ route('admin.booking.checkin.fasilitas', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-blue-500 hover:bg-blue-600">Check-in</button>
                                    </form>
                                @elseif($b->status=='checkin')
                                    <form action="{{ route('admin.booking.checkout.fasilitas', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-indigo-500 hover:bg-indigo-600">Check-out</button>
                                    </form>
                                @elseif($b->status=='checkout')
                                    <form action="{{ route('admin.booking.selesai.fasilitas', $b->id) }}" method="POST" onsubmit="return confirm('Tandai sebagai selesai?')">@csrf
                                        <button class="btn-action bg-green-500 hover:bg-green-600">Selesai</button>
                                    </form>
                                @elseif($b->status=='selesai')
                                    <form action="{{ route('admin.booking.maintenance.fasilitas', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-orange-500 hover:bg-orange-600">Maintenance</button>
                                    </form>
                                @elseif($b->status=='maintenance')
                                    <form action="{{ route('admin.booking.maintenance.done.fasilitas', $b->id) }}" method="POST" onsubmit="return confirm('Selesai maintenance?')">@csrf
                                        <button class="btn-action bg-green-500 hover:bg-green-600">Done</button>
                                    </form>
                                @endif

                                @if($b->status=='pending_cancel')
                                    <form action="{{ route('admin.booking.cancel.fasilitas.approve', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-green-500 hover:bg-green-600">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.booking.cancel.fasilitas.reject', $b->id) }}" method="POST">@csrf
                                        <button class="btn-action bg-red-500 hover:bg-red-600">Reject</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

{{-- Extra CSS for buttons --}}
<style>
    .btn-action {
        @apply text-white px-3 py-1 rounded text-sm transition-colors;
    }
</style>
@endsection
