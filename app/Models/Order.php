<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'order_number',
        'user_id',
        'username',
        'total_amount',
        'currency',
        'status',
        'robux_amount',
        'input_type',
        'total_price',
        'manual_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
