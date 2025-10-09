<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini

class Detail_Booking extends Model
{
    use HasFactory;

    protected $table = 'detail_booking';

    protected $fillable = [
        'booking_id',
        'kamar_id',
        'Nama_Tamu',
        'dewasa',
        'anak',
        'Special Request',
    ];

    // 1. Relasi ke Booking (Induk) - Sudah Benar
    public function booking(): BelongsTo // Tambahkan tipe data kembali (opsional tapi disarankan)
    {
        // Secara default, Laravel akan menggunakan 'booking_id'
        return $this->belongsTo(Booking::class);
    }
    
    // 2. Relasi ke Kamar (Baru ditambahkan) - PENTING
    public function kamar(): BelongsTo 
    {
        // Secara default, Laravel akan menggunakan 'kamar_id'
        return $this->belongsTo(Kamar::class);
    }
}