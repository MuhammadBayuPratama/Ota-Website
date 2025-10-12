<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- ADDED
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class BookingFasilitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'Email',
        'Phone',
        'arrival_time',
        'fasilitas_id',
        'check_in',
        'check_out',
        'durasi',
        'total_harga',
        'status',
    ];
    
    // Ensure the correct table name if it deviates from 'booking_fasilitas'
    // protected $table = 'booking_fasilitas';

   

    /**
     * Aksesor untuk mendapatkan nilai durasi dari properti check_in dan check_out.
     * Dapat diakses sebagai $booking->duration
     */
    public function getDurationAttribute(): int
    {
        // Jika kolom 'durasi' sudah terisi, gunakan nilainya.
        if ($this->attributes['durasi'] !== null) {
            return (int) $this->attributes['durasi'];
        }
        
        // Hitung durasi otomatis jika belum ada nilai
        $checkIn = $this->check_in ? Carbon::parse($this->check_in) : null;
        $checkOut = $this->check_out ? Carbon::parse($this->check_out) : null;

        if ($checkIn && $checkOut) {
            return $checkOut->diffInDays($checkIn);
        }
        
        return 0;
    }

    // --- Relasi ---

    /**
     * Relasi ke User (BelongsTo)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Fasilitas (BelongsTo)
     */
    public function fasilitas(): BelongsTo
    {
        // Menggunakan F besar sesuai import
        return $this->belongsTo(Fasilitas::class);
    }

    /**
     * Relasi ke DetailFasilitas (HasMany) - BARU DITAMBAHKAN
     * Ini adalah PENTING untuk mengatasi error 1452.
     */
    public function detailFasilitas(): HasMany
    {
        // Menghubungkan 'id' dari BookingFasilitas dengan 'booking_id' dari DetailFasilitas
        return $this->hasMany(detail_fasilitas::class, 'booking_id');
    }

    // --- Local Scopes ---

    /**
     * Scope untuk mengambil booking dengan status aktif.
     * Query dapat dipanggil: BookingFasilitas::active()->get()
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['diproses', 'checkin']);
    }
}
