<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

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
        'Special_Request',
    ];

    public function booking(): BelongsTo 
    {
        return $this->belongsTo(Booking::class);
    }
    
    public function kamar(): BelongsTo 
    {
        return $this->belongsTo(Kamar::class);
    }
}