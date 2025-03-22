<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;


class RoomController extends Controller
{
    public function index(){

        $rooms = Room::with('creator')->get();
        return Inertia::render('Rooms/Index', ['rows' => $rooms]);

    }

    public function create(){
       return Inertia::render('Rooms/Create');
    }

    public function store(StoreRoomRequest $request)
    {
       $room_number =$request->room_number ;
       $capacity= $request->capacity;
       $price= $request->price ;
       $is_reserved =$request->is_reserved ;
       $room_creator_id = $request->room_creator_id ;
       $floor_id=$request->floor_id ;


       Room::create([
        'room_number' =>$room_number ,
        'capacity' => $capacity ,
        'price' =>$price ,
        'is_reserved'=>$is_reserved ,
        'floor_id' => $floor_id,
        'room_creator_id' => $room_creator_id
       ]);
       return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit($id){
        $room = Room::findOrFail($id);
        if ($room->room_creator_id !== auth()->id() && auth()->user()->cannot('manage-all-rooms')) {
            abort(403);
        }
        return Inertia::render('Rooms/Edit', ['row' => $room]);
     }



         public function update(UpdateRoomRequest $request, $id)
         {
            $room = Room::findOrFail($id);
             $room->update($request->only('capacity', 'price', 'is_reserved'));

             return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
         }

         public function destroy($id){
            $room = Room::findOrFail($id);
            if($room->room_creator_id !== auth()->id() && auth()->user()->cannot('manage-rooms')) {

                abort(403);

            }
            $room->delete();
           return response( null, 204);
         }
    }
