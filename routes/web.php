<?php

use App\Http\Controllers\FloorController;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ClientController ;
use App\Models\User;
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', ['user' => auth()->user()->load('roles')]);
})->middleware(['auth', 'verified'])->name('dashboard');



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
/************************************************************************************************************************* */
Route::middleware(['can:manage-managers'])->group(function () {
    Route::get('/managers', [ManagerController::class, 'index'])->name('managers.index');
    Route::get('/managers/create', [ManagerController::class, 'create'])->name('managers.create');
    Route::post('/managers', [ManagerController::class, 'store'])->name('managers.store');
    Route::get('/managers/{id}/edit',[ManagerController::class, 'edit'])->name('managers.edit');
    Route::put('/managers/{id}',[ManagerController::class, 'update'])->name('managers.update');
    Route::delete('/managers/{id}',[ManagerController::class, 'destroy'])->name('managers.destroy');
});
/************************************************************************************************************************* */
Route::middleware(['can:manage-receptionists'])->group(function () {
    Route::get('/receptionists', [ReceptionistController::class, 'index'])->name('receptionists.index');
    Route::get('/receptionists/create', [ReceptionistController::class, 'create'])->name('receptionists.create');
    Route::post('/receptionists', [ReceptionistController::class, 'store'])->name('receptionists.store');
    Route::get('/receptionists/{id}/edit',[ReceptionistController::class, 'edit'])->name('receptionists.edit');
    Route::put('/receptionists/{id}',[ReceptionistController::class, 'update'])->name('receptionists.update');
    Route::delete('/receptionists/{id}',[ReceptionistController::class, 'destroy'])->name('receptionists.destroy');
    Route::post('/receptionists/{id}/ban',[ReceptionistController::class, 'ban'])->name('receptionists.ban');
    Route::post('/receptionists/{id}/unban',[ReceptionistController::class, 'unban'])->name('receptionists.unban');
});
/************************************************************************************************************************* */
Route::middleware(['can:manage-clients'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{id}/edit',[ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{id}',[ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}',[ClientController::class, 'destroy'])->name('clients.destroy');
});
Route::middleware(['can:manage-reservations'])->group(function () {
    Route::get('/clients/reservations', [ClientController::class, 'clientsReservations'])->name('clients.reservations');
});
Route::middleware(['can:approve-clients'])->group(function () {
    Route::get('/clients/pending', [ClientController::class, 'pending'])->name('clients.pending');
    Route::post('/clients/{id}/approve', [ClientController::class, 'approve'])->name('clients.approve');
});
Route::middleware(['can:view-my-approved-clients'])->group(function () {
    Route::get('/clients/my-approved-clients', [ClientController::class, 'myApproved'])->name('clients.my_approved_clients');
});
/************************************************************************************************************************* */
Route::middleware(['can:make-reservation'])->group(function () {
    Route::get('/reservations/my-reservations', [ReservationController::class, 'myReservations'])->name('reservations.my_reservations');
    Route::get('/reservations/available-rooms', [ReservationController::class, 'availableRooms'])->name('reservations.available_rooms');
    Route::get('/reservations/available-rooms/{id}', [ReservationController::class, 'makeReservationForm'])->name('reservations.make_reservation_form');
    // Route::post('/reservations/store-reservation/{id}', [ReservationController::class, 'storeReservation'])->name('client.store_reservation');
});
/************************************************************************************************************************* */
Route::middleware(['can:manage-floors'])->group(function () {
    Route::get('/floors', [FloorController::class,'index'])->name('floors.index') ;
    Route::get('/floors/create', [FloorController::class,'create'])->name('floors.create') ;
    Route::post('/floors', [FloorController::class,'store'])->name('floors.store') ;
    Route::get('/floors/{id}/edit', [FloorController::class,'edit'])->name('floors.edit') ;
    Route::put('/floors/{id}', [FloorController::class,'update'])->name('floors.update') ;
    Route::delete('/floors/{id}', [FloorController::class,'destory'])->name('floors.destory') ;
});
/************************************************************************************************************************* */
Route::middleware(['can:manage-rooms'])->group(function () {
    Route::get('/rooms', [RoomController::class,'index'])->name('rooms.index') ;
    Route::get('/rooms/create', [RoomController::class,'create'])->name('rooms.create') ;
    Route::post('/rooms', [RoomController::class,'store'])->name('rooms.store') ;
    Route::get('/rooms/{id}/edit', [RoomController::class,'edit'])->name('rooms.edit') ;
    Route::put('/rooms/{id}', [RoomController::class,'update'])->name('rooms.update') ;
    Route::delete('/rooms/{id}', [RoomController::class,'destroy'])->name('rooms.destroy') ;
});
/************************************************************************************************************************* */
Route::get('/notifications', function () {
    $user = User::orderBy('id', 'desc')->first();

    return response()->json([
        'unread' => $user->unreadNotifications,
        'all' => $user->notifications
    ]);
});
