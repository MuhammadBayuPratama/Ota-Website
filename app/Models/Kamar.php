<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamars';

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'id_category',
        'jumlah',
        'status',
    ];

    // --- RELASI YANG DIBUTUHKAN ---

    // 1. Relasi ke Category (Benar)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    // 2. Relasi ke Detail_Booking (Benar, ini adalah penghubung ke pemesanan)
    public function detailBookings(): HasMany
    {
        // Kamar memiliki banyak Detail_Booking (karena Detail_Booking memiliki kamar_id)
        return $this->hasMany(Detail_Booking::class, 'kamar_id', 'id');
    }
}