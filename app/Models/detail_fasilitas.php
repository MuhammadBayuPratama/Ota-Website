<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini

class detail_fasilitas extends Model
{
    use HasFactory;

    protected $table = 'detail_booking';

    protected $fillable = [
        'booking_id',
        'fasilitas_id',
        'Nama_Tamu',
        'dewasa',
        'anak',
        'Special Request',
    ];

    // 1. Relasi ke Booking (Induk) - Sudah Benar
    public function bookingfasilitas(): BelongsTo // Tambahkan tipe data kembali (opsional tapi disarankan)
    {
        // Secara default, Laravel akan menggunakan 'booking_id'
        return $this->belongsTo(Bookingfasilitas::class);
    }
    
    // 2. Relasi ke Kamar (Baru ditambahkan) - PENTING
    public function fasilitas(): BelongsTo 
    {
        // Secara default, Laravel akan menggunakan 'kamar_id'
        return $this->belongsTo(fasilitas::class);
    }

}