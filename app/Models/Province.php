<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Province extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'province';

    protected $fillable = [
        'name',
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'id_province');
    }
}
