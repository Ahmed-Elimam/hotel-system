<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Floor;
use App\Http\Controllers\Controller;


class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::with(['creator.roles'])->paginate(3);

        return response()->json([
            'success' => true,
            'message' => 'Floors retrieved successfully',
            'data' => $floors
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'unique:floors|required|string|min:3',
        ]);

        $floor = Floor::create([
            'name' => $validated['name'],
            'creator_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Floor created successfully',
            'data' => $floor
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $floor = Floor::findOrFail($id);

        if ($floor->creator_id !== auth()->id() && !auth()->user()->can('manage-all-floors')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'unique:floors|required|string|min:3',
        ]);

        $floor->update(['name' => $validated['name']]);

        return response()->json([
            'success' => true,
            'message' => 'Floor updated successfully',
            'data' => $floor
        ]);
    }

    public function destroy($id)
    {
        $floor = Floor::findOrFail($id);

        if (!auth()->user()->can('manage-all-floors') && $floor->creator_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        if ($floor->rooms()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This floor has rooms, you cannot delete it'
            ], 409);
        }

        $floor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Floor deleted successfully'
        ], 200);
    }
}
