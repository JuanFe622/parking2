<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_id', 'slot_id', 'date_entry', 'vehicle_plate', 'vehicle_type', 'rate_price', 'total_price',  
        ];
}
