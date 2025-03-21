<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Country;


class ClientController extends Controller
{
    public function index()
    {
        $clients = User::role('client')->get();
        return Inertia::render('Clients/Index', ['rows' => $clients]);
    }
    public function create()
    {
        $countries = Country::all();
        return Inertia::render('Clients/Create', ['rows'=> $countries]);
    }
    public function store(ClientStoreRequest $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $national_id = $request->national_id;
        $country = $request->country;
        $phone = $request->phone;
        $gender = $request->gender;
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
            'country' => $country,
            'phone' => $phone,
            'gender'=> $gender,
            'approver_id' => auth()->id(),
        ]);
        $user->assignRole('client');
        return redirect()->route('clients.index');
    }
    public function edit($id)
    {
        $client = User::find($id);
        $countries = Country::all();
        return Inertia::render('Clients/Edit', ['row' => $client, 'rows' => $countries]);
    }
    public function update(ClientUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $name = $request->name;
        $email = $request->email;
        $national_id = $request->national_id;
        $country = $request->country;
        $phone = $request->phone;
        $gender = $request->gender;
        if ($request->hasFile('avatar_image')) {
            // Delete old avatar if it's not the default one
            if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
                \Storage::disk('public')->delete($user->avatar_image);
            }
            // Store new avatar
            $avatarPath = $request->file('avatar_image')->store('avatars', 'public');
            $user->update(['avatar_image' => $avatarPath]);
        }
        $user->update(['name'=> $name,'email'=> $email,'national_id'=> $national_id,'country'=> $country,'phone'=> $phone,'gender'=> $gender]);
        return redirect()->route('clients.index');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
            \Storage::disk('public')->delete($user->avatar_image);
        }
        $user->delete();
        return response(null, 204);
    }
    public function pending()
    {
        $clients = User::role('pending-client')->get();
        return Inertia::render('Clients/Pending', ['rows' => $clients]);
    }
    public function approve($id)
    {
        $client = User::findOrFail($id);
        $client->approver_id = auth()->id();
        $client->save();
        $client->removeRole('pending-client');
        $client->assignRole('client');
        return redirect()->route('clients.pending');
    }
    public function approved()
    {
        $clients = User::role('client')->where('approver_id',auth()->id())->get();
        return Inertia::render('Clients/Approved', ['rows' => $clients]);
    }

}
