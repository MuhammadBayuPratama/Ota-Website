@extends('layouts.app_admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="flex h-screen bg-gray-50 ml-60">
    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <!-- Content -->
        <main class="p-6 flex-1 overflow">
            <div class="p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="rounded-xl border bg-white p-6 shadow-sm">
                        <h2 class="text-sm font-medium text-gray-500">Total Kamar</h2>
                        <p class="text-2xl font-bold mt-2">{{ $totalKamar }}</p>
                    </div>
                    <div class="rounded-xl border bg-white p-6 shadow-sm">
                        <h2 class="text-sm font-medium text-gray-500">Fasilitas</h2>
                        <p class="text-2xl font-bold mt-2">{{ $totalFasilitas }}</p>
                    </div>
                    <div class="rounded-xl border bg-white p-6 shadow-sm">
                        <h2 class="text-sm font-medium text-gray-500">Kategori</h2>
                        <p class="text-2xl font-bold mt-2">{{ $totalKategori }}</p>
                    </div>
                    <div class="rounded-xl border bg-white p-6 shadow-sm">
                        <h2 class="text-sm font-medium text-gray-500">Total Booking</h2>
                        <p class="text-2xl font-bold mt-2">{{ $totalBooking }}</p>
                    </div>
                </div>

                <!-- Charts Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Booking Kamar -->
                    <div class="rounded-xl border bg-white p-6 shadow-sm">
                        <h2 class="text-base font-semibold mb-4">Booking Per Bulan</h2>
                        <canvas id="bookingChart" height="120"></canvas>
                    </div>

                    <!-- Booking Fasilitas -->
                    <div class="rounded-xl border bg-white p-6 shadow-sm">
                        <h2 class="text-base font-semibold mb-4">Booking Fasilitas Per Bulan</h2>
                        <canvas id="fasilitasChart" height="120"></canvas>
                    </div>

                    <!-- Pendapatan -->
                    <div class="rounded-xl border bg-white p-6 shadow-sm">
                        <h2 class="text-base font-semibold mb-4">Pendapatan Per Bulan</h2>
                        <canvas id="barChart" height="120"></canvas>
                    </div>

                    <!-- Status Booking -->
                    <div class="rounded-xl border bg-white p-6 shadow-sm">
                        <h2 class="text-base font-semibold mb-4">Status Booking</h2>
                        <canvas id="doughnutChart" height="40"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let bookingChartInstance, fasilitasChartInstance, barChartInstance, doughnutChartInstance;

document.addEventListener("DOMContentLoaded", function () {
    // --- Booking Kamar ---
    if (bookingChartInstance) bookingChartInstance.destroy();
    bookingChartInstance = new Chart(document.getElementById('bookingChart'), {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Jumlah Booking Kamar',
                data: @json($bookingData),
                backgroundColor: '#3b82f6',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Booking Kamar Tahun ' + new Date().getFullYear() }
            },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // --- Booking Fasilitas ---
    if (fasilitasChartInstance) fasilitasChartInstance.destroy();
    fasilitasChartInstance = new Chart(document.getElementById('fasilitasChart'), {
        type: 'bar',
        data: {
            labels: @json($fasilitasMonths),
            datasets: [{
                label: 'Jumlah Booking Fasilitas',
                data: @json($fasilitasData),
                backgroundColor: '#f59e0b',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Booking Fasilitas Tahun ' + new Date().getFullYear() }
            },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // --- Pendapatan ---
    if (barChartInstance) barChartInstance.destroy();
    barChartInstance = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($pendapatanData),
                backgroundColor: '#10b981',
                borderRadius: 6
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    // --- Status Booking ---
    if (doughnutChartInstance) doughnutChartInstance.destroy();
    doughnutChartInstance = new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: @json($statusLabels),
            datasets: [{
                data: @json($statusData),
                backgroundColor: ['#22c55e','#3b82f6','#ef4444' ,'#5C3E94' , '#BADFDB']
            }]
        }
    });
});
</script>
@endpush
