<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ReceptionistController extends Controller
{
    /**
     * Display a listing of the receptionists.
     */
    public function index(): JsonResponse
    {
        $receptionists = User::role('receptionist')->paginate(5);
        return response()->json([
            'success' => true,
            'message' => 'Receptionists retrieved successfully.',
            'data' => $receptionists
        ]);
    }

    /**
     * Store a newly created receptionist.
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $avatarImage = $request->hasFile('avatar_image') 
            ? $request->file('avatar_image')->store('avatars', 'public') 
            : 'avatar.jpg';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'national_id' => $request->national_id,
            'avatar_image' => $avatarImage,
            'creator_id' => auth()->id(),
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        $user->assignRole('receptionist');

        return response()->json([
            'success' => true,
            'message' => 'Receptionist created successfully.',
            'data' => $user
        ], 201);
    }

    /**
     * Update the specified receptionist.
     */
    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-receptionists')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($request->hasFile('avatar_image')) {
            if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
                Storage::disk('public')->delete($user->avatar_image);
            }
            $user->avatar_image = $request->file('avatar_image')->store('avatars', 'public');
        }

        $user->update($request->only(['name', 'email', 'national_id']));

        return response()->json([
            'success' => true,
            'message' => 'Receptionist updated successfully.',
            'data' => $user
        ]);
    }

    /**
     * Remove the specified receptionist.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-receptionists')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
            Storage::disk('public')->delete($user->avatar_image);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Receptionist deleted successfully.'
        ], 204);
    }

    /**
     * Ban the specified receptionist.
     */
    public function ban($id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-receptionists')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $user->ban();
        $user->tokens()->delete(); 

        return response()->json([
            'success' => true,
            'message' => 'Receptionist banned successfully.'
        ]);
    }

    /**
     * Unban the specified receptionist.
     */
    public function unban($id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-receptionists')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $user->unban();

        return response()->json([
            'success' => true,
            'message' => 'Receptionist unbanned successfully.'
        ]);
    }
}
