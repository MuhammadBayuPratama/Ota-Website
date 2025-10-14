<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class detail_fasilitas extends Model 
{
    use HasFactory;

    protected $table = 'detail_fasilitas'; 

    protected $fillable = [
        'booking_id',
        'fasilitas_id',
        'Nama_Tamu',
        'dewasa',
        'anak',
        'Special_Request',
    ];

  
    public function bookingfasilitas(): BelongsTo
    {
        return $this->belongsTo(BookingFasilitas::class, 'booking_id');
    }
    
  
    public function fasilitas(): BelongsTo 
    {
        return $this->belongsTo(Fasilitas::class, 'fasilitas_id');
    }

}
