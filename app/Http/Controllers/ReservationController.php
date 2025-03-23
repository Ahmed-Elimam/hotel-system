<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use App\Notifications\ClientApprovedNotification;

use App\Models\Room;
use App\Models\User;
class ReservationController extends Controller
{
    public function manageClients(){
        $clients = User::with(['reservations' => function($query) {
            $query->where('is_approved', false);
        }])->get();
        return Inertia::render('Receptionist/ManageClients', [ 'rows'=>$clients  ]);
    }
    public function myApprovedClients(){
        $clients =User::with(['reservations' => function($query) {
            $query->where('is_approved', false)->where('approved_by', Auth::id());
        }])->get();

        return Inertia::render('Receptionist/MyApprovedClients', [
            'clients' => $clients,
        ]);

    }
    public function approveClient(User $client)
    {

        $client->update([
            'is_approved' => true,
            'approved_by' => Auth::id(),
        ]);
        $client->notify(new ClientApprovedNotification($client));
        return redirect()->route('receptionist.manage_clients')->with('success', 'Client approved successfully.');
    }


    public function availableRooms()
    {
        $rooms = Room::where('is_reservate', false)->get();
        return Inertia::render('Client/AvailableRooms', [
            'rooms' => $rooms,
        ]);
    }

    public function reservationForm(Room $room)
    {
        return Inertia::render('Client/ReservationForm', [
            'room' => $room,
        ]);
    }

    public function myReservations()
    {
        $reservations = Reservation::where('client_id', Auth::id())->get();

        return Inertia::render('Client/MyReservations', [
            'reservations' => $reservations
        ]);
    }
    public function storeReservation(StoreReservationRequest $request, Room $room)
    {
        $reservation = Reservation::create([
            'client_id' => auth()->id(),
            'room_id' => $room->id,
            'accompany_number' => $request->accompany_number,
            'paid_price' => $room->price,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
        ]);
        $room->update(['is_reservate' => true]);
        return redirect()->route('client.payment', $reservation->id);
    }

    

}
