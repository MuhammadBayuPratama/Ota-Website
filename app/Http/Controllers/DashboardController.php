<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingFasilitas;
use App\Models\Kamar;
use App\Models\Fasilitas;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        // -------------------------
        // Stats Cards
        // -------------------------
        $totalKamar = Kamar::count();
        $totalFasilitas = Fasilitas::count();
        $totalKategori = Category::count();
        $totalBooking = Booking::count();

        // -------------------------
        // 1️⃣ Booking Kamar per Bulan
        // -------------------------
        $bookings = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $bookingData = [];
        foreach(range(1,12) as $m) {
            $bookingData[] = $bookings[$m] ?? 0;
        }

        // -------------------------
        // 2️⃣ Pendapatan per Bulan
        // -------------------------
        $pendapatan = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_harga) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        $pendapatanData = [];
        foreach(range(1,12) as $m) {
            $pendapatanData[] = $pendapatan[$m] ?? 0;
        }

        // -------------------------
        // 3️⃣ Status Booking (Doughnut Chart)
        // -------------------------
        $statusDataRaw = Booking::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusLabels = $statusDataRaw->keys()->toArray();
        $statusData = $statusDataRaw->values()->toArray();

        // -------------------------
        // 4️⃣ Booking Fasilitas per Bulan
        // -------------------------
        $fasilitasBookings = BookingFasilitas::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

        $fasilitasMonths = $months;
        $fasilitasData = [];
        foreach(range(1,12) as $m) {
            $fasilitasData[] = $fasilitasBookings[$m] ?? 0;
        }

        // -------------------------
        // Return ke view
        // -------------------------
        return view('admin.dashboard', compact(
            'totalKamar','totalFasilitas','totalKategori','totalBooking',
            'months','bookingData','pendapatanData',
            'statusLabels','statusData',
            'fasilitasMonths','fasilitasData'
        ));
    }
}
