<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ParkingController;
use App\Http\Controllers\api\v1\TypeController;
use App\Http\Controllers\api\v1\VehicleController;
use App\Http\Controllers\api\v1\OwnerController;
use App\Http\Controllers\api\v1\SlotController;
use App\Http\Controllers\api\v1\BillController;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('v1/parkings', \App\Http\Controllers\api\v1\ParkingController::class);
    Route::apiResource('v1/types', \App\Http\Controllers\api\v1\TypeController::class);
    Route::apiResource('v1/vehicles', \App\Http\Controllers\api\v1\VehicleController::class);
    Route::apiResource('v1/owners', \App\Http\Controllers\api\v1\OwnerController::class);
    Route::apiResource('v1/slots', \App\Http\Controllers\api\v1\SlotController::class);
    Route::apiResource('v1/bills', \App\Http\Controllers\api\v1\BillController::class);

    Route::post('v1/owner', [OwnerController::class, 'store']);
    Route::post('v1/vehicle', [VehicleController::class, 'store']);

    Route::get('v1/owners', [OwnerController::class, 'index']);
    Route::get('v1/vehicles', [VehicleController::class, 'index']);
    Route::get('v1/slots?available', [SlotController::class, 'index']);
    Route::get('v1/slots?unavailable', [SlotController::class, 'index']);

    Route::post('v1/bill', [BillController::class, 'store']);
    Route::get('v1/bill/{bill_id}', [BillController::class, 'update']);

    Route::get('v1/stats', [BillController::class, 'showVehiclesParked']);


    Route::post('/v1/logout', [App\Http\Controllers\api\v1\AuthController::class,'logout'])->name('api.logout');

});


Route::post(
    '/v1/login',
    [
        App\Http\Controllers\api\v1\AuthController::class,
        'login'
    ]
)->name('api.login');
