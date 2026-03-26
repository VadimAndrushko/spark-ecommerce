<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'gateway',
        'transaction_id',
        'amount',
        'status',
        'response_data',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'response_data' => 'array',
        'processed_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
