<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\RoomRequest;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('creator.roles','floor')->get();
        return Inertia::render('Rooms/Index', ['rows' => $rooms]);
    }
    public function create(){
       return Inertia::render('Rooms/Create');
    }
    public function store(RoomRequest $request)
    {
       $room_number = $request->room_number ;
       $capacity = $request->capacity;
       $price = $request->price ;
       $floor_id=$request->floor_id;

       Room::create([
        'room_number' =>$room_number,
        'capacity' => $capacity,
        'price' =>$price,
        'floor_id' => $floor_id,
        'room_creator_id' => auth()->id(),
       ]);
       return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);    
        return Inertia::render('Rooms/Edit', ['row' => $room]);
    }
    public function update(RoomRequest $request, $id)
    {
        $room = Room::findOrFail($id);
        if ($room->room_creator_id !== auth()->id() && auth()->user()->cannot('manage-all-rooms')) {
            abort(403);
        }
        $capacity = $request->capacity;
        $price = $request->price ;
        $floor_id=$request->floor_id;
        $room->update([
            'capacity' => $capacity,
            'price' =>$price,
            'floor_id' => $floor_id,
        ]);
        return redirect()->route('rooms.index')->with('success','Room updated successfully');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        if($room->room_creator_id !== auth()->id() && auth()->user()->cannot('manage-all-rooms')) {
            abort(403);
        }
        if(!$room->is_reserved) { // is_reserved default value is false
            $room->delete();
            return response()->json(['success' => 'Room deleted successfully.'], 204);
        }else{
            return response()->json(['error' => "You can't delete a reserved room."], 409);
        }
    }
    }
