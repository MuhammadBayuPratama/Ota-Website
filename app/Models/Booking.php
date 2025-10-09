<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
// 💡 Pastikan Anda mengimpor Model-model yang berelasi
use App\Models\User;
use App\Models\DetailBooking; // 💡 Perbaikan: Gunakan DetailBooking (tanpa underscore) jika Modelnya DetailBooking
use App\Models\Addon;

class Booking extends Model
{
    use HasFactory;

    // --- CASTS ---
    protected $casts = [
        // 'arrival_time' => 'datetime:H:i', // 💡 Lebih baik cast sebagai 'string' jika hanya menyimpan jam, atau 'datetime' tanpa format
        'check_in'      => 'date',
        'check_out'     => 'date',
    ];

    // --- FILLABLE ---
    protected $fillable = [
        'user_id',
        'Email',
        'Phone',
        'pemesan',
        'arrival_time',
        'check_in',
        'check_out',
        'durasi',
        'total_harga',
        'status',
    ];
    
    // --- RELATIONS ---

    /**
     * Relasi ke User (Pemesan).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke DetailBooking (menunjukkan kamar-kamar yang dipesan).
     * @return HasMany
     */
    public function detailBookings(): HasMany
    {
        // 💡 Asumsi: Nama Model Detail Booking Anda adalah 'DetailBooking' (tanpa underscore)
        // Jika nama tabel/model Anda menggunakan underscore (Detail_Booking), ganti DetailBooking::class
        return $this->hasMany(Detail_Booking::class, 'booking_id');
    }
    
    /**
     * Relasi ke Addons (Many-to-Many).
     * @return BelongsToMany
     */
    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(Addon::class, 'booking_addon')
                    ->withPivot('quantity') // Mengambil kolom quantity dari tabel pivot
                    ->withTimestamps();
    }
    
    // --- UTILITIES ---

    /**
     * Menghitung durasi booking secara manual (hari).
     * @return int
     */
    public function calculateDuration(): int
    {
        // Pastikan properti sudah di-cast sebagai objek Carbon jika menggunakan $this->check_in
        // Namun, karena sudah di-cast di $casts, kita bisa langsung akses
        if (!$this->check_in || !$this->check_out) {
            return 0;
        }
        
        // 💡 Memastikan bahwa date accessor bekerja, atau menggunakan Carbon::parse
        // Jika check_in dan check_out di-cast sebagai 'date', mereka sudah menjadi instance Carbon.
        if ($this->check_in instanceof Carbon && $this->check_out instanceof Carbon) {
             return $this->check_out->diffInDays($this->check_in);
        }

        // Fallback jika casting gagal (tidak seharusnya terjadi)
        return Carbon::parse($this->check_out)->diffInDays(Carbon::parse($this->check_in));
    }

    /**
     * Scope query untuk mengambil booking yang masih aktif.
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['diproses', 'checkin']);
    }
}