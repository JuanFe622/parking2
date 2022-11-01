<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Parking;


class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parking::create([
            'name' => 'Parqueadero UAM',
            'address' => 'Antigua Estación del Ferrocarril Manizales',
            'nit' => '8908050510',
        ]);
    }
}
