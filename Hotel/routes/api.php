<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\Habitacion2Controller;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/guardar_orden', [HotelController::class, 'guardar_orden'])
    ->name('guardar_orden');

Route::post('/validar-disponibilidad', [HotelController::class, 'validarDisponibilidad']);

Route::get('/habitaciones', [Habitacion2Controller::class, 'obtenerHabitaciones']);
Route::post('/recibir-carrito',[CarritoController::class,'recibirCarrito']);


