<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function userRole()
    {
        return $this->hasOne(UserRole::class);
    }

    public function provider()
    {
        return $this->hasOne(Provider::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function isCustomer()
    {
        return $this->userRole && $this->userRole->role === 'customer';
    }

    public function isProvider()
    {
        return $this->userRole && $this->userRole->role === 'provider';
    }

    public function isAdmin()
    {
        return $this->userRole && $this->userRole->role === 'admin';
    }
    
}
