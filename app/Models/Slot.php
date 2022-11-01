<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_id', 'available', 'vehicle_plate', 'rate_price', 'total_price'
        ];

    protected $casts = [
        'date_entry' => 'dateTime',
        'date_entry' => 'dateTime',
        ];

    public function owner()
    {
        return $this->belongsTo(Parking::class, 'id'); 
    }
           
}
