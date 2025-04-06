<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'role_id',
        'status',
        'note',
        'avatar',
    ];

    // Mối quan hệ với Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }
    // app/Models/User.php

    public function defaultAddress()
    {
        return $this->hasOne(UserAddress::class)->where('is_default', 1);
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    //settings
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
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
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Thêm sắp xếp mặc định theo created_at giảm dần
    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('created_at', 'desc');
        });
    }

    /**
     * Get the user's avatar URL.
     */
    public function getAvatarAttribute($value)
    {
        return $value ? $value : 'avatar/default.jpg';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->role_id) {
                $user->assignRole('customer'); // Gán vai trò mặc định
            }
        });
    }
}
