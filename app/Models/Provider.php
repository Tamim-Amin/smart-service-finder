<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'bio',
        'experience_years',
        'hourly_rate',
        'location',
        'is_available',
        'is_verified',
        'average_rating',
        'total_reviews',
        'total_earnings',
    ];
    protected $casts = [
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'total_earnings' => 'decimal:2', // Add this line
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
