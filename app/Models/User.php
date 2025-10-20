<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserRole;
use Illuminate\Support\Str; // <-- 1. Import Str class

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ----------------------------------------------------
    // UUID Configuration (Fix for the 'id' field error)
    // ----------------------------------------------------
    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false; // <-- 2. Tell Eloquent not to auto-increment

    /**
     * The data type of the primary key.
     * @var string
     */
    protected $keyType = 'string'; // <-- 3. Set primary key type to string

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // 4. Generate UUID before the model is created
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    // ----------------------------------------------------

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRole::class,
    ];
    
    public static function ValidRole($role)
    {
        return in_array($role, [self::ROLE_ADMIN, self::ROLE_USER]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    
    public function isAdmin(): bool
{
    return $this->role instanceof UserRole
        ? $this->role->value === self::ROLE_ADMIN
        : $this->role === self::ROLE_ADMIN;
}

public function isUser(): bool
{
    return $this->role instanceof UserRole
        ? $this->role->value === self::ROLE_USER
        : $this->role === self::ROLE_USER;
}

    
}
