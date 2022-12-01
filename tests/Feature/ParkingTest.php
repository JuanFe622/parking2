<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ParkingTest extends TestCase

{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    //Utilizar el sgt comando en el vagrant para correr las pruebas
    //php artisan migrate:refresh --seed

    
    public function test_parking_vehicle_in_an_unavailable_slot()
    {
        $user = User::find(1);
        $parking_id = 1;
        $slot_id = 1; // Este slot siempre va a estar ocupado
        $vehicle_plate = 'ABC123';
        $vehicle_type = 'Car';

        $response = $this
            ->actingAs($user)
            ->postJson('/api/v1/bill', [
                'parking_id' => $parking_id,
                'slot_id' => $slot_id,
                'vehicle_plate' => $vehicle_plate,
                'vehicle_type' => $vehicle_type,
            ])
            ->assertStatus(400)
            ->assertJson([
                'data' => 'Slot not available, please choose an available slot',
            ]);

            $this-> assertDatabaseHas('slots', [ // Verificar que el slot no se actualizo
                'vehicle_plate' => $vehicle_plate,
                'id' => $slot_id,
            ]);
            
    }

    public function test_parking_vehicle_in_unregistered_slot()
    {
        $user = User::find(1);
        $parking_id = 1;
        $slot_id = 16; // En la base de datos solo hay 15 slots disponibles
        $vehicle_plate = 'ABC123';
        $vehicle_type = 'Car';

        $response = $this
            ->actingAs($user)
            ->postJson('/api/v1/bill', [
                'parking_id' => $parking_id,
                'slot_id' => $slot_id,
                'vehicle_plate' => $vehicle_plate,
                'vehicle_type' => $vehicle_type,
            ])
            ->assertStatus(400)
            ->assertJson([
                'data' => 'Slot not found',
            ]);
            
            $this->assertDatabaseMissing('slots', [ // Verificar que el slot no se haya creado
                'id' => $slot_id,
            ]);
    }

    public function test_parking_vehicle_already_parked()
    {
        $user = User::find(1);
        $parking_id = 1;
        $slot_id = 2; 
        $vehicle_plate = 'ABC123'; // Este vehiculo ya esta estacionado
        $vehicle_type = 'Car';

        $response = $this
            ->actingAs($user)
            ->postJson('/api/v1/bill', [
                'parking_id' => $parking_id,
                'slot_id' => $slot_id,
                'vehicle_plate' => $vehicle_plate,
                'vehicle_type' => $vehicle_type,
            ])
            ->assertStatus(400)
            ->assertJson([
                'data' => 'Vehicle already parked',
            ]); 
            
        $this-> assertDatabaseHas('slots', [ // Verificar que el slot sigue estando ocupado
            'vehicle_plate' => $vehicle_plate,
            'available' => false,
        ]);
    }

    public function test_parking_vehicle_correctly()
    {
        $user = User::find(1);
        $parking_id = 1;
        $slot_id = 2; 
        $vehicle_plate = 'ABC456';
        $vehicle_type = 'Car';

        $response = $this
            ->actingAs($user)
            ->postJson('/api/v1/bill', [
                'parking_id' => $parking_id,
                'slot_id' => $slot_id,
                'vehicle_plate' => $vehicle_plate,
                'vehicle_type' => $vehicle_type,
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => 'Vehicle successfully parked',
            ]);   
            
        $this->assertDatabaseHas('bills', [ // Verificar que se creo el tiquete en la base de datos
            'parking_id' => $parking_id,
            'slot_id' => $slot_id,
            'vehicle_plate' => $vehicle_plate,
            'vehicle_type' => $vehicle_type,
        ]);
    }

    public function test_unparking_vehicle_with_unregistered_bill_id()
    {
        $user = User::find(1);
        $bill_id = 100; // Este bill no existe en la base de datos

        $response = $this
            ->actingAs($user)
            ->getJson("/api/v1/bill/$bill_id")
            ->assertStatus(400)
            ->assertJson([
                'data' => 'Bill not found',
            ]);   
            
            $this->assertDatabaseMissing('bills', [ // Verificar que el tiquete no se haya creado
                'id' => $bill_id,
            ]);
    }

    public function test_unparking_vehicle_correctly()
    {
        $user = User::find(1);
        $bill_id = 1; // Este bill se creo con la prueba de parking (test_parking_vehicle_correctly)

        $response = $this
            ->actingAs($user)
            ->getJson("/api/v1/bill/$bill_id") 
            ->assertStatus(200)
            ->assertJson([
                'data' => 'Vehicle successfully unparked', 
            ]);  

        $this->assertDatabaseHas('bills', [  // Verificar que el bill se actualizo correctamente
            'id' => $bill_id,
            'date_departure' => now(),
        ]);
    }

    public function test_show_available_slots()
    {
        $user = User::find(1);

        $response = $this
            ->actingAs($user)
            ->getJson("/api/v1/slots?available")
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'ID',
                        'Parking ID',
                        'Available',
                        'Vehicle Plate',
                    ]
                ]
            ]);
        
        $this->assertDatabaseHas('slots', [ // Verifica que los slots estan disponibles
            'available' => true,
        ]);
    }

    
}


