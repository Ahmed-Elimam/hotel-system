<?php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ManagerController;
use App\Http\Controllers\TestNotificationController;
use App\Notifications\ClientApprovedNotification;
use App\Http\Controllers\Api\FloorController;
use Illuminate\Database\Capsule\Manager;
use Inertia\Inertia;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ReceptionistController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ClientController ;
use Illuminate\Validation\ValidationException;

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken($request->device_name)->plainTextToken;
});


Route::middleware(['auth:sanctum','can:manage-managers'])->group(function () {
    Route::get('/managers', [ManagerController::class, 'index'])->name('managers.index');
    Route::post('/managers', [ManagerController::class, 'store'])->name('managers.store');
    Route::get('/managers/{id}/edit',[ManagerController::class, 'edit'])->name('managers.edit');
    Route::put('/managers/{id}',[ManagerController::class, 'update'])->name('managers.update');
    Route::delete('/managers/{id}',[ManagerController::class, 'destroy'])->name('managers.destroy');
});
/************************************************************************************************************************* */
Route::middleware(['auth:sanctum','can:manage-receptionists'])->group(function () {
    Route::get('/receptionists', [ReceptionistController::class, 'index'])->name('receptionists.index');
    Route::post('/receptionists', [ReceptionistController::class, 'store'])->name('receptionists.store');
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
Route::middleware(['auth:sanctum','can:manage-floors'])->group(function () {
    Route::get('/floors', [FloorController::class,'index'])->name('floors.index') ;
    Route::post('/floors', [FloorController::class,'store'])->name('floors.store') ;
    Route::put('/floors/{id}', [FloorController::class,'update'])->name('floors.update') ;
    Route::delete('/floors/{id}', [FloorController::class,'destroy'])->name('floors.destroy') ;
});
/************************************************************************************************************************* */
Route::middleware(['auth:sanctum','can:manage-rooms'])->group(function () {
    Route::get('/rooms', [RoomController::class,'index'])->name('rooms.index') ;
    Route::post('/rooms', [RoomController::class,'store'])->name('rooms.store') ;
    Route::put('/rooms/{id}', [RoomController::class,'update'])->name('rooms.update') ;
    Route::delete('/rooms/{id}', [RoomController::class,'destroy'])->name('rooms.destroy') ;
});
