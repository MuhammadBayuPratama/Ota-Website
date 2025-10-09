<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Impor yang baik

class Addon extends Model
{
    // Pastikan fillable sudah benar
    protected $fillable = ['name', 'price'];

    /**
     * Relasi Many-to-Many ke Booking melalui tabel pivot 'booking_addon'.
     */
    public function bookings(): BelongsToMany
    {
        // 1. Ganti 'booking_addons' menjadi 'booking_addon'
        // 2. Ganti 'jumlah' menjadi 'quantity'
        return $this->belongsToMany(Booking::class, 'booking_addon')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}