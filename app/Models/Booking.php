<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'provider_id',
        'problem_description',
        'service_date',
        'service_time',
        'estimated_duration',
        'estimated_cost',
        'payment_method',
        'payment_status',
        'transaction_id',
        'status',
        'total_amount',  // Add this line
        'total_hours'    // Add this line
    ];

    protected $casts = [
        'service_date' => 'date',
        'total_amount' => 'decimal:2',  // Add this line
        'estimated_cost' => 'decimal:2', // Add this line
        'estimated_duration' => 'decimal:2' // Add this line
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function unreadMessagesFor($userId)
    {
        return $this->messages()
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();
    }
}
