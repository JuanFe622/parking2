<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Slot;
use Illuminate\Http\Request;

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

        $slot = Slot::find($request->input('slot_id'));
        $slot->vehicle_plate = $request->input('vehicle_plate');
        $slot->available = 0;

        $slot->save();
        $bill->save();

        return response()->json(['data' => $bill], 201);
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
    public function update(Request $request, Bill $bill)
    {
        $bill->update($request->all());
 
        return response()->json(['data' => $bill], 200);
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
}
