<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'customer_name', 'total_weight', 'price_per_unit',
        'subtotal', 'payment_method', 'payment_status', 'payment_date', 'proof_of_transfer'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
