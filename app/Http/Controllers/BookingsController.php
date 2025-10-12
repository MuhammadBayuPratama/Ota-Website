<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kamar;
use App\Models\Addon;
use App\Models\Fasilitas;
use App\Models\BookingFasilitas;
use App\Models\Detail_Booking;
use App\Models\detail_fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingsController extends Controller
{
    public function index()
{
    $bookings = \App\Models\Booking::with(['kamar','addons'])->get();

    $result = $bookings->map(function ($booking) {
        return [
            'id'          => $booking->id,
            'nama_tamu'   => $booking->Nama_Tamu,
            'email'       => $booking->Email,
            'kamar'       => $booking->kamar->name ?? null,
            'check_in'    => $booking->check_in,
            'check_out'   => $booking->check_out,
            'durasi'      => $booking->durasi,
            'dewasa'      => $booking->dewasa,
            'anak'        => $booking->anak,
            'total_harga' => $booking->total_harga,
            'status'      => $booking->status,
            'addons'      => $booking->addons->map(function ($addon) {
                return [
                    'id'       => $addon->id,
                    'name'     => $addon->name,
                    'harga'    => $addon->pivot->harga,
                    'jumlah'   => $addon->pivot->jumlah,
                    'subtotal' => $addon->pivot->subtotal,
                ];
            }),
        ];
    });

    return response()->json([
        'success' => true,
        'data'    => $result
    ]);
}

    /**
     * Show booking form.
     */
public function create(Request $request)
{
    $kamars = Kamar::all(); // ← tambah ini
    $addons = Addon::all(); // Pastikan Addon::all() mengembalikan data
    $selectedKamar = $request->query('kamar_id') ? Kamar::find($request->query('kamar_id')) : null;

    return view('user.booking_form', compact('kamars', 'selectedKamar','addons'));
}



public function createfasilitas(Request $request)
{
    // Mengambil semua data Fasilitas utama
    $facilities = Fasilitas::all();
    
    // Mengambil data Add-ons
    $addons = Addon::all();
    
    // Mengambil Fasilitas yang dipilih dari parameter URL 'facility_id'
    // PERBAIKAN: Menggunakan 'facility_id' sesuai URL
    $selectedfasilitas = $request->query('facility_id') ? Fasilitas::find($request->query('facility_id')) : null;

    // Mengirimkan data ke view 'user.booking_fasilitas'
    return view('user.booking_fasilitas', compact('facilities', 'selectedfasilitas', 'addons'));
}


/**
 * Menyimpan data booking ke database.
 */
public function store(Request $request)
{
    // 1. Pengecekan Autentikasi
    if (!Auth::check()) {
        return $request->wantsJson()
            ? response()->json(['success'=>false,'message'=>'Login dulu'], 401)
            : redirect()->route('login');
    }

    // 2. Validasi Input
    try {
        $validated = $request->validate([
            'kamar_ids'       => 'required|array|min:1',
            'kamar_ids.*'     => 'exists:kamars,id',
            'Nama_Tamu'       => 'required|string|max:255',
            'arrival_time'    => 'required|date_format:H:i',
            'check_in'        => 'required|date|after_or_equal:today',
            'check_out'       => 'required|date|after:check_in',
            'Phone'           => 'required|string',
            'dewasa'          => 'required|int|min:1',
            'anak'            => 'required|int|min:0',
            'Special_Request' => 'nullable|string',
            'addons'          => 'nullable|array',
            'addons.*'        => 'exists:addons,id',
        ]);
    } catch (ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    }

    // Hitung Durasi
    $durasi = Carbon::parse($validated['check_out'])->diffInDays(Carbon::parse($validated['check_in']));
    $durasi = max(1, $durasi); // Minimal 1 hari
    
    $total_harga = 0;
    $kamarDetailData = []; 
    $addonsToAttach = []; 

    // 3. Pengecekan Ketersediaan dan Perhitungan Harga Kamar
    foreach (array_unique($validated['kamar_ids']) as $kamarId) {
        
        // Logika Pengecekan Overlap: Mencari kamar yang dipesan di Detail_Booking
        $overlap = Detail_Booking::where('kamar_id', $kamarId)
            ->whereHas('booking', function ($q) use ($validated) {
                $q->whereIn('status', ['diproses','checkin'])
                  ->where(function($q_inner) use ($validated) {
                      // Logika standar cek tumpang tindih tanggal
                      $q_inner->where('check_in', '<', $validated['check_out'])
                              ->where('check_out', '>', $validated['check_in']);
                  });
            })
            ->exists();


        // Siapkan data untuk Detail_Booking
        $kamar = Kamar::findOrFail($kamarId);
        $hargaKamar = $kamar->price * $durasi;
        $total_harga += $hargaKamar;
        
        // *** PERUBAHAN DI SINI ***
        // Menambahkan data 'dewasa' dan 'anak' dari model Kamar
        $kamarDetailData[] = [
            'kamar_id'          => $kamarId,
            'Nama_Tamu'         => $validated['Nama_Tamu'],
            'durasi'            => $durasi,
            'dewasa'            => $validated['dewasa'], // Ambil dari kamar
            'anak'              => $validated['anak'],   // Ambil dari kamar
        ];
    }

    // 4. Perhitungan Harga Add-ons dan persiapan Attach
    if (!empty($validated['addons'])) {
        foreach (array_unique($validated['addons']) as $addon_id) {
            $addon = Addon::findOrFail($addon_id);
            $total_harga += $addon->price; 
            // Siapkan data untuk attach: key=addon_id, value=array pivot data (quantity)
            $addonsToAttach[$addon->id] = ['quantity' => 1]; 
        }
    }
    
    // 5. Buat Entitas Booking Utama
    $booking = Booking::create([
        'user_id'      => Auth::id(),
        'Email'        => Auth::user()->email,
        'Phone'        => $validated['Phone'],
        'arrival_time' => $validated['arrival_time'],
        'check_in'     => $validated['check_in'],
        'check_out'    => $validated['check_out'],
        'durasi'       => $durasi,
        'total_harga'  => $total_harga, 
        'status'       => 'diproses',
    ]);

    // 6. Simpan Detail Booking (Kamar)
    foreach ($kamarDetailData as $detailData) {
        Detail_Booking::create(array_merge($detailData, [
            'booking_id'        => $booking->id,
            'Special_Request'   => $validated['Special_Request'],
        ]));
    }

    // 7. Attach Add-ons menggunakan Relasi Many-to-Many
    if (!empty($addonsToAttach)) {
        // Memanggil relasi addons() yang ada di Model Booking
        $booking->addons()->attach($addonsToAttach);
    }

    // 8. Pesan dan Respons
    $msg = 'Booking berhasil dibuat! Durasi: '.$durasi.' hari. Total Rp. '. number_format($total_harga, 0, ',', '.');
    if (!empty($addonsToAttach)) {
        $addonNames = Addon::whereIn('id', array_keys($addonsToAttach))->pluck('name')->toArray();
        $msg .= ' (dengan addons: '.implode(', ', $addonNames).')';
    }

    return $request->wantsJson()
        ? response()->json(['success'=>true,'message'=>$msg,'data'=>$booking], 201)
        : redirect()->route('booking.history')->with('success',$msg);
}


public function storefasilitas(Request $request)
{
    // 1. Pengecekan Autentikasi
    if (!Auth::check()) {
        return $request->wantsJson()
            ? response()->json(['success'=>false,'message'=>'Login dulu'], 401)
            : redirect()->route('login');
    }

    // 2. Validasi Input
    try {
        $validated = $request->validate([
            // Tidak perlu diubah, karena input form masih 'fasilitas_ids'
            'fasilitas_ids'     => 'required|array|min:1',
            'fasilitas_ids.*'   => 'exists:fasilitas,id',
            'Nama_Tamu'         => 'required|string|max:255',
            'arrival_time'      => 'required|date_format:H:i',
            'check_in'          => 'required|date|after_or_equal:today',
            'check_out'         => 'required|date|after:check_in',
            'Phone'             => 'required|string',
            'Special_Request'   => 'nullable|string',
            'addons'            => 'nullable|array',
            'addons.*'          => 'exists:addons,id',
        ]);
    } catch (ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    }

    // Hitung Durasi
    $durasi = Carbon::parse($validated['check_out'])->diffInDays(Carbon::parse($validated['check_in']));
    $durasi = max(1, $durasi); // Minimal 1 hari
    
    $total_harga = 0;
    $fasilitasDetailData = []; 
    $addonsToAttach = []; 

    // 3. Pengecekan Ketersediaan dan Perhitungan Harga Kamar
    foreach (array_unique($validated['fasilitas_ids']) as $fasilitasId) {
        
        $fasilitas = Fasilitas::findOrFail($fasilitasId);
        $hargafasilitas = $fasilitas->price * $durasi;
        $total_harga += $hargafasilitas;
        
        // Data untuk Detail Fasilitas
        $fasilitasDetailData[] = [
            'fasilitas_id'      => $fasilitasId,
            'Nama_Tamu'         => $validated['Nama_Tamu'],
            'durasi'            => $durasi,
            'dewasa'            => $fasilitas->max_adults ?? 1, 
            'anak'              => $fasilitas->max_children ?? 0, 
            'Special Request'   => $validated['Special_Request'],
        ];
    }

    // 4. Perhitungan Harga Add-ons dan persiapan Attach
    if (!empty($validated['addons'])) {
        foreach (array_unique($validated['addons']) as $addon_id) {
            $addon = Addon::findOrFail($addon_id);
            $total_harga += $addon->price; 
            $addonsToAttach[$addon->id] = ['quantity' => 1]; 
        }
    }
    
    // 5. Buat Entitas Booking Utama
    // Tambahkan baris 'Email' ke list fillable di model BookingFasilitas.php
    $booking = BookingFasilitas::create([
        'user_id'      => Auth::id(),
        'Email'        => Auth::user()->email,
        'Phone'        => $validated['Phone'],
        'arrival_time' => $validated['arrival_time'],
        'check_in'     => $validated['check_in'],
        'check_out'    => $validated['check_out'],
        'durasi'       => $durasi,
        'total_harga'  => $total_harga, 
        'status'       => 'diproses',
    ]);

    // 6. Simpan Detail Booking (Kamar)
    foreach ($fasilitasDetailData as $detailData) {
        $booking->detailFasilitas()->create($detailData);
    }
    
    // 7. Attach Add-ons menggunakan Relasi Many-to-Many
    if (!empty($addonsToAttach)) {
        $booking->addons()->attach($addonsToAttach);
    }

    // 8. Pesan dan Respons
    $msg = 'Booking berhasil dibuat! Durasi: '.$durasi.' hari. Total Rp. '. number_format($total_harga, 0, ',', '.');
    if (!empty($addonsToAttach)) {
        $addonNames = Addon::whereIn('id', array_keys($addonsToAttach))->pluck('name')->toArray();
        $msg .= ' (dengan addons: '.implode(', ', $addonNames).')';
    }

    return $request->wantsJson()
        ? response()->json(['success'=>true,'message'=>$msg,'data'=>$booking], 201)
        : redirect()->route('booking.history')->with('success',$msg);
}
    /**
     * Cancel booking kamar.
     */
    public function cancelBooking($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        if ($booking->user_id !== Auth::id()) return redirect()->back()->with('error','Tidak berhak membatalkan booking ini.');
        if (in_array($booking->status,['cancelled','pending'])) return redirect()->back()->with('error','Booking sudah dibatalkan atau menunggu persetujuan.');

        $booking->status = 'pending_cancel';
        $booking->save();

        return redirect()->back()->with('success','Permintaan pembatalan booking terkirim.');
    }

    /**
     * Cancel booking fasilitas.
     */
    public function cancelBookingFasilitas($id)
    {
        $booking = BookingFasilitas::findOrFail($id);
        if ($booking->user_id !== Auth::id()) return redirect()->back()->with('error','Tidak berhak membatalkan booking ini.');
        if (in_array($booking->status,['cancelled','pending'])) return redirect()->back()->with('error','Booking sudah dibatalkan atau menunggu persetujuan.');

        $booking->status = 'pending_cancel';
        $booking->save();

        return redirect()->back()->with('success','Permintaan pembatalan booking fasilitas terkirim.');
    }

    /**
     * Booking history.
     */
// App/Http/Controllers/BookingController.php

public function history()
{
    $userId = Auth::id();
    
    // 🛑 PERBAIKAN UTAMA DI SINI
    // Mengganti relasi yang tidak terdefinisi ('kamar')
    // dengan relasi bertingkat yang benar: 'detailBookings' (di Model Booking) 
    // lalu 'kamar' (di Model DetailBooking).
    $bookingsKamar = Booking::where('user_id', $userId)
                             ->with('detailBookings.kamar') // FIX: Menggunakan relasi bertingkat
                             ->orderBy('created_at', 'desc')
                             ->get();
                             
    $bookingsFasilitas = BookingFasilitas::where('user_id', $userId)
                                          ->with('fasilitas')
                                          ->orderBy('created_at', 'desc')
                                          ->get();
                                          
    return view('user.booking_history', compact('bookingsKamar', 'bookingsFasilitas'));
}


/**
 * Admin: list all bookings.
 */
public function adminIndex()
{
    // 🛑 PERBAIKAN UTAMA: 
    // Mengganti 'kamar' dengan relasi bertingkat yang benar: 'detailBookings.kamar'
    $bookingsKamar = Booking::with(['user', 'detailBookings.kamar'])
                            ->orderBy('created_at', 'desc')
                            ->get();
                            
    // Kode untuk fasilitas booking tetap sama
    $bookingsFasilitas = BookingFasilitas::with(['user', 'fasilitas'])
                                          ->orderBy('created_at', 'desc')
                                          ->get();
                                          
    return view('admin.booking.index', compact('bookingsKamar', 'bookingsFasilitas'));
}

    /**
     * Admin: Approve / Reject cancel kamar.
     */
    public function approveCancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();
        return redirect()->back()->with('success','Booking berhasil dibatalkan oleh admin.');
    }

    public function rejectCancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'diproses';
        $booking->save();
        return redirect()->back()->with('success','Permintaan cancel ditolak, status dikembalikan ke diproses.');
    }

    /**
     * Admin: Approve / Reject cancel fasilitas.
     */
    public function approveCancelFasilitas($id)
    {
        $booking = BookingFasilitas::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();
        return redirect()->back()->with('success','Booking fasilitas berhasil dibatalkan oleh admin.');
    }

    public function rejectCancelFasilitas($id)
    {
        $booking = BookingFasilitas::findOrFail($id);
        $booking->status = 'diproses';
        $booking->save();
        return redirect()->back()->with('success','Permintaan cancel fasilitas ditolak, status dikembalikan ke diproses.');
    }
// App/Http/Controllers/BookingController.php

/**
 * Admin: Check-in Kamar.
 */
public function checkin($id)
{
    // 1. Mengambil Booking dengan relasi bertingkat ke DetailBooking dan Kamar
    $booking = Booking::with('detailBookings.kamar')->findOrFail($id);

    // 2. Cek Status Booking
    if ($booking->status !== 'diproses') {
        return back()->with('error', 'Booking tidak bisa check-in karena statusnya bukan "diproses".');
    }

    // 3. Cek Ketersediaan Kamar secara iteratif
    // Kita harus memastikan SEMUA kamar di booking ini tersedia
    foreach ($booking->detailBookings as $detail) {
        $kamar = $detail->kamar;

        // Cek apakah jumlah kamar di inventaris sudah habis
        // Catatan: Asumsi $kamar->jumlah adalah stok kamar yang tersedia saat ini.
        if ($kamar->jumlah < 1) { 
            return back()->with('error', 'Check-in GAGAL: Kamar ' . $kamar->name . ' tidak tersedia (stok habis).');
        }
    }
    
    // 4. Jika SEMUA kamar tersedia, lakukan transaksi Check-in
    
    try {
        // A. Update Status Booking
        $booking->status = 'checkin';
        $booking->save();

        // B. Kurangi Jumlah/Stok Kamar yang Dipakai
        $successCount = 0;
        foreach ($booking->detailBookings as $detail) {
            $kamar = $detail->kamar;
            
            // Mengurangi stok kamar sebanyak 1 unit (asumsi 1 detail booking = 1 kamar)
            // Jika Anda memiliki kolom quantity di detail booking, gunakan $detail->quantity
            $kamar->jumlah -= 1; 
            $kamar->save();
            $successCount++;
        }
        
        return back()->with('success', "Check-in berhasil. {$successCount} jenis kamar telah dikurangi stoknya.");

    } catch (\Exception $e) {
        // Handle jika ada error saat save ke database
        // Anda mungkin ingin menambahkan logic rollback di sini jika menggunakan transaksi database
        return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
}

// App/Http/Controllers/BookingController.php

/**
 * Admin: Checkout Kamar.
 */
public function checkout($id)
{
    // 1. Ambil Booking dan relasi Kamar melalui DetailBooking
    $booking = Booking::with('detailBookings.kamar')->findOrFail($id);

    // 2. Cek Status Booking
    if ($booking->status !== 'checkin') {
        return back()->with('error', 'Checkout GAGAL: Booking tidak dalam status "checkin".');
    }
    
    // 3. Update Status Booking menjadi 'checkout'
    $booking->status = 'checkout';
    $booking->save();
    
    // 4. Kembalikan Stok Kamar
    $restoredCount = 0;
    
    // Karena satu booking bisa memiliki banyak kamar (melalui DetailBooking), kita harus mengulanginya
    foreach ($booking->detailBookings as $detail) {
        $kamar = $detail->kamar;
        
        // Asumsi: Kita mengembalikan 1 unit kamar per DetailBooking.
        // Jika Anda menggunakan kolom 'quantity' di DetailBooking, gunakan: $kamar->jumlah += $detail->quantity;
        $kamar->jumlah += 1; 
        $kamar->save();
        $restoredCount++;
    }

    return back()->with('success', "Checkout berhasil. Booking telah selesai dan stok {$restoredCount} jenis kamar telah dikembalikan.");
}

    /**
     * Admin: Set selesai kamar.
     */
    public function setSelesaiKamar($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'selesai';
        $booking->save();
        return redirect()->back()->with('success','Booking kamar ditandai selesai.');
    }

    /**
     * Admin: Set selesai fasilitas.
     */
    public function setSelesaiFasilitas($id)
    {
        $booking = BookingFasilitas::findOrFail($id);
        $booking->status = 'selesai';
        $booking->save();
        return redirect()->back()->with('success','Booking fasilitas ditandai selesai.');
    }

    /**
     * Admin: Set maintenance kamar.
     */
    public function setMaintenanceKamar($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->status === 'selesai') {
            $booking->status = 'maintenance';
            $booking->save();
            return back()->with('success', 'Booking kamar masuk maintenance.');
        }
        return back()->with('error', 'Booking kamar tidak bisa diubah ke maintenance.');
    }

    /**
     * Admin: Set maintenance fasilitas.
     */
    public function setMaintenanceFasilitas($id)
    {
        $bookingFasilitas = BookingFasilitas::findOrFail($id);
        if ($bookingFasilitas->status === 'selesai') {
            $bookingFasilitas->status = 'maintenance';
            $bookingFasilitas->save();
            return back()->with('success', 'Booking fasilitas masuk maintenance.');
        }
        return back()->with('error', 'Booking fasilitas tidak bisa diubah ke maintenance.');
    }

// App/Http/Controllers/BookingController.php

/**
 * Admin: Done maintenance kamar.
 */
public function setMaintenanceDoneKamar($id)
{
    // 1. Ambil Booking dengan relasi Kamar melalui DetailBooking (Fix Relasi)
    $booking = Booking::with('detailBookings.kamar')->findOrFail($id);

    // 2. Cek Status Booking
    if ($booking->status !== 'maintenance') {
        return back()->with('error', 'Booking kamar tidak dalam status maintenance.');
    }

    // 3. Update Status Booking menjadi 'selesai'
    $booking->status = 'selesai';
    $booking->save();

    // 4. Kembalikan Stok Kamar
    $restoredCount = 0;

    // Ulangi semua kamar yang terlibat dalam booking maintenance ini
    foreach ($booking->detailBookings as $detail) {
        $kamar = $detail->kamar;
        
        // 💡 PENTING: Tambahkan kembali stok kamar yang sebelumnya dikurangi untuk maintenance
        $kamar->jumlah += 1; 
        $kamar->save();
        $restoredCount++;
    }

    // 5. Berikan feedback yang akurat
    return back()->with('success', "Maintenance kamar selesai. {$restoredCount} jenis kamar telah ditambahkan kembali ke stok.");
}

    /**
     * Admin: Done maintenance fasilitas.
     */
    public function setMaintenanceDoneFasilitas($id)
    {
        $bookingFasilitas = BookingFasilitas::findOrFail($id);
        if ($bookingFasilitas->status === 'maintenance') {
            $bookingFasilitas->status = 'selesai';
            $bookingFasilitas->save();
            return back()->with('success', 'Booking fasilitas selesai maintenance.');
        }
        return back()->with('error', 'Booking fasilitas tidak dalam status maintenance.');
    }

    /**
 * Admin: Check-in Fasilitas.
 */
public function checkinFasilitas($id)
{
    $booking = BookingFasilitas::with('fasilitas')->findOrFail($id);

    if ($booking->status !== 'diproses') {
        return back()->with('error', 'Booking fasilitas tidak bisa check-in.');
    }

    $booking->status = 'checkin';
    $booking->save();

    return back()->with('success', 'Check-in fasilitas berhasil.');
}

/**
 * Admin: Checkout Fasilitas.
 */
public function checkoutFasilitas($id)
{
    $booking = BookingFasilitas::findOrFail($id);

    if ($booking->status !== 'checkin') {
        return back()->with('error','Booking fasilitas tidak bisa checkout.');
    }

    $booking->status = 'checkout';
    $booking->save();

    return back()->with('success','Checkout fasilitas berhasil.');
}


}
