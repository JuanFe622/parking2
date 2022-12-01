<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Slot;
use App\Models\Parking;


class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'vehicle_plate' => 'ABC123',
            'available' => false,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);

        Slot::create([
            'parking_id' => Parking::all()->random()->id,
            'available' => true,
        ]);
    }
}
