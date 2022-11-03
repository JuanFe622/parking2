<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Slot;
use App\Models\Parking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\SlotCollection;
use App\Http\Resources\api\v1\SlotResource;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $slots = Slot::orderBy('id', 'asc')->get();

        if($request->has('available')){
            $slots = $slots->where('available', '=', 1);
        }

        //$slots = $slots->get();

        // return response()->json(['data' => $slots], 200);

        // return (new SlotCollection($slots))
        // ->response()
        // ->setStatusCode(200);

        return response()->json(['data' => SlotResource::collection($slots)], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slot = Slot::create($request->all());
 
        return response()->json(['data' => $slot], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function show(Slot $slots)
    {
        return (new SlotResource($slots))
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slot $slot)
    {
        $slot->update($request->all());
 
        return response()->json(['data' => $slot], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slot $slot)
    {
        $slot->delete();
        return response(null, 204);
    }
}
