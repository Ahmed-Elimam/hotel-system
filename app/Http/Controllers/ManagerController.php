<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managers = User::role('manager')->get();
        return Inertia::render('Managers/Index', ['rows' => $managers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create()
    {
        return Inertia::render('Managers/Create');
    }
    public function store(UserStoreRequest $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $national_id = $request->national_id;
        if ($request->hasFile('avatar_image')) {
            $avatar_image = $request->file('avatar_image')->store('avatars', 'public');
        } else {
            $avatar_image = 'avatar.jpg';
        }

        $user = User::create([
            'name' => $name, 
            'email' => $email, 
            'password' => $password, 
            'national_id' => $national_id, 
            'avatar_image' => $avatar_image,
            'creator_id' => auth()->id(),
        ]);
        $user->assignRole('manager');
        return to_route('managers.index');
    }
    public function edit($id)
    {
        $manager = User::find($id);
        return Inertia::render('Managers/Edit', ['row' => $manager]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $name = $request->name;
        $email = $request->email;
        $national_id = $request->national_id;

        $user = User::findOrFail($id);
        $user->update(['name' => $name, 'email' => $email, 'national_id' => $national_id,]);
        return to_route('managers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id); // Prevents errors if user not found

        if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
            Storage::disk('public')->delete($user->avatar_image);
        }   
        $user->delete();

        return response( null, 204);
    }
}
