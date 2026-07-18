<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'unit', 'estimated_days', 'description', 'is_active'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
