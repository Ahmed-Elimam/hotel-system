<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use App\Models\Room;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function myReservations()
    {
        $reservations = Reservation::where('client_id', Auth::id())->get();
        return response()->json(['reservations' => $reservations]);
    }

    public function availableRooms()
    {
        $rooms = Room::where('is_reserved', false)->get();
        return response()->json(['rooms' => $rooms]);
    }

}
