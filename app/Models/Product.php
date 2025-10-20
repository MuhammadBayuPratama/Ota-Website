<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'image',
        'description',
        'price',
        'id_category',
        'id_vendor',
        'jumlah',
        'max_adults',
        'max_children',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'jumlah' => 'integer',
        'max_adults' => 'integer',
        'max_children' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id_vendor');
    }
}
