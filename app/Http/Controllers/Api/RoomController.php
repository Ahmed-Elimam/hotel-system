<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Models\Floor;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index()
    {
        $rows = Room::with(['creator', 'floor:id,floor_number,name'])->paginate(5);
        foreach ($rows as $row) {
            $row->is_reserved = $row->is_reserved ? "Reserved" : "Available";
        }

        return response()->json([
            'rows' => $rows,
            'user' => auth()->user()->load('roles'),
        ]);
    }

    public function store(RoomRequest $request)
    {
        $room = Room::create([
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'price' => $request->price * 100,
            'floor_id' => $request->floor_id,
            'is_reserved' => $request->is_reserved,
            'room_creator_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'Room created successfully', 'room' => $room], 201);
    }

    public function update(RoomRequest $request, $id)
    {
        $room = Room::findOrFail($id);
        if ($room->room_creator_id !== auth()->id() && auth()->user()->cannot('manage-all-rooms')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $room->update([
            'capacity' => $request->capacity,
            'price' => $request->price * 100,
            'floor_id' => $request->floor_id,
            'is_reserved' => $request->is_reserved,
        ]);

        return response()->json(['message' => 'Room updated successfully', 'room' => $room], 200);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        if ($room->room_creator_id !== auth()->id() && auth()->user()->cannot('manage-all-rooms')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$room->is_reserved) {
            $room->delete();
            return response()->json(['message' => 'Room deleted successfully'], 200);
        }

        return response()->json(['error' => "You can't delete a reserved room."], 409);
    }
}
