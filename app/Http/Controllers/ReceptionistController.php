<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

use Illuminate\Support\Facades\Storage;

class ReceptionistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receptionists = User::role('receptionist')->paginate(5);
        return Inertia::render('Receptionists/Index', ['rows' => $receptionists]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return Inertia::render('Receptionists/Create');
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
        $user->assignRole('receptionist');
        return to_route('receptionists.index');
    }
    public function edit($id)
    {
        $receptionist = User::find($id);
        return Inertia::render('Receptionists/Edit', ['row' => $receptionist]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if($user->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-receptionists')) {
            abort(403);
        }
        $name = $request->name;
        $email = $request->email;
        $national_id = $request->national_id;
        if ($request->hasFile('avatar_image')) {
            // Delete old avatar if it's not the default one
            if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
                \Storage::disk('public')->delete($user->avatar_image);
            }
            // Store new avatar
            $avatarPath = $request->file('avatar_image')->store('avatars', 'public');
            $user->update(['avatar_image' => $avatarPath]);
        }
        $user->update(['name' => $name, 'email' => $email, 'national_id' => $national_id,]);
        return to_route('receptionists.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $receptionist = User::findOrFail($id);
        if($receptionist->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-receptionists')) {
            abort(403);
        }
        if ($receptionist->avatar_image && $receptionist->avatar_image !== 'avatar.jpg') {
            Storage::disk('public')->delete($receptionist->avatar_image);
        }
        $receptionist->delete();

        return response( null, 204);
    }
    public function ban($id)
    {
        $receptionist = User::findOrFail($id);
        if($receptionist->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-receptionists')) {
            abort(403);
        }
        $receptionist->ban();
        return to_route('receptionists.index');
    }
    public function unban($id)
    {
        $receptionist = User::findOrFail($id);
        if($receptionist->creator_id !== auth()->id() && auth()->user()->cannot('manage-all-receptionists')) {
            abort(403);
        }
        $receptionist->unban();
        return to_route('receptionists.index');
    }
}
