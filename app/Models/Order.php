<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'customer_name', 'customer_whatsapp',
        'customer_address', 'service_id', 'weight', 'notes',
        'pickup_date', 'pickup_time', 'status'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $date = now()->format('Ymd');
                $lastOrder = static::where('order_number', 'like', 'LDR-' . $date . '%')->latest()->first();
                $nextNumber = $lastOrder ? ((int)substr($lastOrder->order_number, -4)) + 1 : 1;
                $order->order_number = 'LDR-' . $date . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
