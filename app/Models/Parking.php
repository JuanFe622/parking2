<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'nit',
    ];

    public function slots()
    {
        return $this->hasMany(Slot::class, 'id');
    }

}
