<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Controllers\Controller;


class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managers = User::role('manager')->paginate(5);
        return response()->json([
            'managers' => $managers,
            'user' => auth()->user()->load('roles')
        ]);
    }

    /**
     * Store a newly created manager.
     */
    public function store(UserStoreRequest $request)
    {
        $avatar_image = $request->hasFile('avatar_image') 
            ? $request->file('avatar_image')->store('avatars', 'public') 
            : 'avatar.jpg';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'national_id' => $request->national_id,
            'avatar_image' => $avatar_image,
            'creator_id' => auth()->id(),
        ]);

        $user->assignRole('manager');

        return response()->json(['message' => 'Manager created successfully', 'manager' => $user], 201);
    }

    /**
     * Update the specified manager.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->hasFile('avatar_image')) {
            if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
                Storage::disk('public')->delete($user->avatar_image);
            }
            $avatar_image = $request->file('avatar_image')->store('avatars', 'public');
            $user->avatar_image = $avatar_image;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'national_id' => $request->national_id,
        ]);

        return response()->json(['message' => 'Manager updated successfully', 'manager' => $user]);
    }

    /**
     * Remove the specified manager.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
            Storage::disk('public')->delete($user->avatar_image);
        }

        $user->delete();

        return response()->json(['message' => 'Manager deleted successfully'], 204);
    }
}
