<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::with(['creator.roles'])->get();
    public function index()
    {
        $floors = Floor::with(['creator.roles'])->get();
        return Inertia::render('Floors/Index', ['rows' => $floors]);
    }
    public function create()
    {
    public function create()
    {
        return Inertia::render('Floors/Create');
    }
    public function store(Request $request)
    {
    public function store(Request $request)
    {
         $request->validate([
             'name' => 'required|string|min:3',
         ]);

         Floor::create([
            'name'=> $request->name,
            'creator_id' => auth()->id(),
         ]);
         return redirect()->route('floors.index');
    }
    public function edit($id)
    {
        $floor= Floor::findOrFail($id) ;
        return Inertia::render('Floors/Edit', ['row' => $floor]);
    }
    public function update(Request $request, $id)
    {
         return redirect()->route('floors.index');
    }
    public function edit($id)
    {
        $floor= Floor::findOrFail($id) ;
        return Inertia::render('Floors/Edit', ['row' => $floor]);
    }
    public function update(Request $request, $id)
    {
        $floor= Floor::findOrFail($id) ;
        if ($floor->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-floors')) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|min:3',
        ]);
        $floor->update($request->only('name'));

        return redirect()->route('floors.index');
    }
    public function destroy($id){

        $floor= Floor::findOrFail($id) ;
        if($floor->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-floors')) {
            abort(403);
        }
        if($floor->rooms()->exists()){
            return response('This floor has rooms, you can not delete it', 409);
        }
        else{
        $floor->delete();
        return response(null, 204);
        }
    }
}
