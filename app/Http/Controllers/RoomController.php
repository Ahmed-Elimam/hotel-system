<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\RoomRequest;

use App\Models\User;
use App\Models\Floor;

class RoomController extends Controller
{
   

public function index()
{
    $rows = Room::with(['creator', 'floor:id,floor_number,name'])->paginate(5);
    foreach ($rows as $row) {
     $row->is_reserved = $row->is_reserved ? "Reserved" : "Available";
    
    }

    return Inertia::render('Rooms/Index', [
        'rows' => $rows,
        'user' => auth()->user()->load('roles'),
        
    ]);
}


    public function create(){
       return Inertia::render('Rooms/Create',
        ['user' => auth()->user()->load('roles'), 'floors'=> Floor::all()] );
    } 
    public function store(RoomRequest $request)
    {
       $room_number =$request->room_number ;
       $capacity= $request->capacity;
       $price= $request->price ;
       $is_reserved =$request->is_reserved ;
       $floor_id=$request->floor_id ;


       Room::create([
        'room_number' =>$room_number,
        'capacity' => $capacity,
        'price' =>$price*100,
        'floor_id' => $floor_id,
        'is_reserved' => $is_reserved,
        'room_creator_id' => auth()->id(),
       ]);
       return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);    
        return Inertia::render('Rooms/Edit', ['row' => $room, 'user' => auth()->user()->load('roles'), 'floors'=> Floor::get()]);
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
        $is_reserved =$request->is_reserved ;
        $room->update([
            'capacity' => $capacity,
            'price' =>$price*100,
            'floor_id' => $floor_id,
            'is_reserved' => $is_reserved,
        ]);
        return redirect()->route('rooms.index')->with('success','Room updated successfully');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        if($room->room_creator_id !== auth()->id() && auth()->user()->cannot('manage-all-rooms')) {
            abort(403);
        }
        if(!$room->is_reserved) { 
            $room->delete();
            return response()->json(['success' => 'Room deleted successfully.'], 200);
        }else{
            return response()->json(['error' => "You can't delete a reserved room."], 409);
        }
    }
    }
