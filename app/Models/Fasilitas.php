<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'id_category',
        'jumlah',
        'status',
    ];

    // 1. Relasi ke Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    // 2. Relasi detailfasilitas()
    public function detailfasilitas(): HasMany
    {
        // Foreign key di tabel detail_booking adalah 'kamar_id' (sesuai model detail_fasilitas Anda)
        return $this->hasMany(detail_fasilitas::class, 'fasilitas_id', 'id');
    }
    
    // 3. Relasi bookingsFasilitas() yang digunakan di Blade
    public function bookingfasilitas(): HasMany
    {
        // Ini adalah relasi yang dipanggil di Blade
        return $this->hasMany(detail_fasilitas::class, 'fasilitas_id', 'id');
    }

    /**
     * Helper untuk menghitung jumlah booking fasilitas yang aktif.
     * Status 'diproses' dan 'checkin' berada di tabel 'BookingFasilitas' (melalui relasi di detail_fasilitas).
     * @return int
     */
    public function getActiveBookingsCount(): int
    {
        // PERBAIKAN: Menggunakan relasi 'booking' (huruf kecil) yang merujuk ke BookingFasilitas.
        // Asumsi model detail_fasilitas memiliki relasi public function booking().
        return $this->bookingFasilitas()
            ->whereHas('bookingfasilitas', function ($query) { 
                $query->whereIn('status', ['diproses', 'checkin']);
            })
            ->count();
    }
}
