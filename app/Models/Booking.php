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
        'status'
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
}
