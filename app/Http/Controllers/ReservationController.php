<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use App\Notifications\ClientApprovedNotification;

use App\Models\Room;
use App\Models\User;
use GuzzleHttp\Client;

class ReservationController extends Controller
{

    public function myReservations()
    {
        $reservations = Reservation::where('client_id', Auth::id())->with('room')->paginate(5);
        $clientName = Auth::user()->name;
        return Inertia::render('Reservations/MyReservations', [
            'rows' => $reservations,
            'clientName' => $clientName,
        ]);
    }
    public function availableRooms()
    {
        $rooms = Room::where('is_reserved', false)->get();
        return Inertia::render('Reservations/AvailableRooms', [
            'rows' => $rooms,
        ]);
    }
    public function makeReservationForm($id)
    {
        $room = Room::findOrFail($id);
        return Inertia::render('Reservations/ReservationForm', [
            'room' => $room,
        ]);
    }
    // public function porceedToStripe(ReservationRequest $request, $id)
    // {
    //     $room = Room::findOrFail($id);
    //     $accompany_number = $request->accompany_number;
    //     $check_in = Carbon::parse($request->check_in);
    //     $check_out = Carbon::parse($request->check_out);
    //     $total_price = ($room->price)*($check_out->diffInDays($check_in));
    //     $client_id = Auth::id();

    // }



}
