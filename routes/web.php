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
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::middleware(['can:manage-managers'])->group(function () {
    Route::get('/managers', [ManagerController::class, 'index'])->name('managers.index');
    Route::get('/managers/create', [ManagerController::class, 'create'])->name('managers.create');
    Route::post('/managers', [ManagerController::class, 'store'])->name('managers.store');
    Route::get('/managers/{id}/edit',[ManagerController::class, 'edit'])->name('managers.edit');
    Route::put('/managers/{id}',[ManagerController::class, 'update'])->name('managers.update');
    Route::delete('/managers/{id}',[ManagerController::class, 'destroy'])->name('managers.destroy');
});
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
Route::middleware(['can:manage-clients'])->group(function () {
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{id}/edit',[ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/{id}',[ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}',[ClientController::class, 'destroy'])->name('clients.destroy');
});
Route::middleware(['can:approve-clients'])->group(function () {
    Route::get('/clients/pending', [ClientController::class, 'pending'])->name('clients.pending');
    Route::post('/clients/{id}/approve', [ClientController::class, 'approve'])->name('clients.approve');
    // Route::post('/clients/{id}/reject', [ClientController::class, 'reject'])->name('clients.reject');
});
Route::middleware(['can:view-my-approved-clients'])->get('/clients/approved', [ClientController::class, 'approved'])->name('clients.approved');


Route::middleware(['can:manage-floors'])->group(function () {
    Route::get('/floor', [FloorController::class,'index'])->name('floors.index') ;
    Route::get('/floor/create', [FloorController::class,'create'])->name('floors.create') ;
    Route::post('/floor', [FloorController::class,'store'])->name('floors.store') ;
    Route::get('/floor/{id}/edit', [FloorController::class,'edit'])->name('floors.edit') ;
    Route::put('/floor/{id}', [FloorController::class,'update'])->name('floors.update') ;
    Route::delete('/floor/{id}', [FloorController::class,'destory'])->name('floors.destory') ;
});

Route::middleware(['can:manage-rooms'])->group(function () {
    Route::get('/room', [RoomController::class,'index'])->name('rooms.index') ;
    Route::get('/room/create', [RoomController::class,'create'])->name('rooms.create') ;
    Route::post('/room', [RoomController::class,'store'])->name('rooms.store') ;
    Route::get('/room/{id}/edit', [RoomController::class,'edit'])->name('rooms.edit') ;
    Route::put('/room/{id}', [RoomController::class,'update'])->name('rooms.update') ;
    Route::delete('/room/{id}', [RoomController::class,'destory'])->name('rooms.destory') ;
});


Route::middleware(['can:manage-reservations'])->group(function () {
    Route::get('/receptionist/manage-clients', [ReservationController::class, 'manageClients'])->name('receptionist.manage_clients');
    Route::post('/receptionist/approve-client/{client}', [ReservationController::class, 'approveClient'])->name('receptionist.approve_client');
    Route::get('/receptionist/my-approved-clients', [ReservationController::class, 'myApprovedClients'])->name('receptionist.my_approved_clients');
    Route::get('/receptionist/clients-reservations', [ReservationController::class, 'clientsReservations'])->name('receptionist.clients_reservations');
});


Route::middleware(['can:manage-client-reservation'])->group(function () {
    Route::get('/client/available-rooms', [ReservationController::class, 'availableRooms'])->name('client.available_rooms');
    Route::get('/client/reservation-form/{room}', [ReservationController::class, 'reservationForm'])->name('client.reservation_form');
    Route::post('/client/store-reservation/{room}', [ReservationController::class, 'storeReservation'])->name('client.store_reservation');
    Route::get('/client/my-reservations', [ReservationController::class, 'myReservations'])->name('client.my_reservations');
});


Route::get('/notifications', function () {
    $user = User::orderBy('id', 'desc')->first();

    return response()->json([
        'unread' => $user->unreadNotifications,
        'all' => $user->notifications
    ]);
});
