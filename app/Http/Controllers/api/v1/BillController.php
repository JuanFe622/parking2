<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::orderBy('id', 'asc')->get();
 
        return response()->json(['data' => $bills], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $bill = Bill::create($request->all());

        $current_date = date('Y-m-d H:i:s');

        $bill = new bill();
        $bill->parking_id = $request->input('parking_id');
        $bill->slot_id = $request->input('slot_id');
        $bill->date_entry = $current_date;
        $bill->vehicle_plate = $request->input('vehicle_plate');
        $bill->vehicle_type = $request->input('vehicle_type');


        $plate = $request->input('vehicle_plate');
        $exists = DB::table('slots')->where('vehicle_plate', $plate)->exists();

        if (($slot = Slot::find($request->input('slot_id'))) == null) {
            return response()->json(['data' => 'Slot not found'], 400);
        }else{
            $slot = Slot::find($request->input('slot_id'));

            if ($slot->available == 0) {
                return response()->json(['data' => 'Slot not available, please choose an available slot'], 400);
            } else {
                if($exists){
                    return response()->json(['data' => 'Vehicle already parked'], 400);
                }else{
                    $slot->available = 0;
                    $slot->vehicle_plate = $request->input('vehicle_plate');
                    $slot->save();
                    $bill->save();
    
                    return response()->json(['data' => 'Vehicle successfully parked'], 201);
                }
                
            }
        }
         
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        return response()->json(['data' => $bill], 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bill $bill, $id)
    {
        $current_date = date('Y-m-d H:i:s');

        if(($bill = Bill::find($id)) == null){
            return response()->json(['data' => 'Bill not found'], 400);
        }else{
            $bill = Bill::find($id);
            $bill->date_departure = $current_date;
            $bill->save();

            $slot_id = DB::table('bills')->where('id', $id)->value('slot_id');

            $slot = Slot::find($slot_id);
            $slot->vehicle_plate = null;
            $slot->available = 1;
            $slot->save();

            return response()->json(['data' => 'Vehicle successfully unparked'], 200);
        }
        
 
        return response()->json(['data' => $bill, 'Vehicle successfully unparked'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();
        return response(null, 204);
    }

    public function showVehiclesParked()
    {
        $carsParked = DB::table('bills')->where('vehicle_type', 'Car')->where('date_departure', null)->count();
        $motorcyclesParked = DB::table('bills')->where('vehicle_type', 'Motorcycle')->where('date_departure', null)->count();
        $slotsAvailable = DB::table('slots')->where('available', 1)->count();
        return response()->json(['data' => 
        'Cars parked: ' . $carsParked . 
        ' | Motorcycles parked: ' . $motorcyclesParked . 
        ' | Available Slots: ' .$slotsAvailable 
        ], 200);
    }
}
