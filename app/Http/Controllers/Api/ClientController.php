<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Country;
use App\Models\Client;
use App\Models\Reservation;
use App\Notifications\ClientApprovedNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::role(['client', 'pending-client'])
        ->with('country')
        ->orderBy('id', 'desc')
        ->paginate(5);
        return response()->json(['clients' => $clients]);
    }

    public function store(ClientStoreRequest $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $national_id = $request->national_id;
        $country_id = $request->country_id;
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
            'country_id' => $country_id,
            'phone' => $phone,
            'gender'=> $gender,
            'approver_id' => auth()->id(),
        ]);
        $user->assignRole('client');

        return response()->json(['message' => 'Client created successfully', 'client' => $user], 201);
    }

    public function update(ClientUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('avatar_image')) {
            if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
                \Storage::disk('public')->delete($user->avatar_image);
            }
            $data['avatar_image'] = $request->file('avatar_image')->store('avatars', 'public');
        }

        $user->update($data);

        return response()->json(['message' => 'Client updated successfully', 'client' => $user]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Reservation::where('client_id', $user->id)->delete();

        if ($user->avatar_image && $user->avatar_image !== 'avatar.jpg') {
            \Storage::disk('public')->delete($user->avatar_image);
        }

        $user->delete();

        return response()->json(['message' => 'Client deleted successfully'], 204);
    }

    public function pending()
    {
        $clients = User::role('pending-client')->get();
        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }


    public function approve($id)
    {
        $client = User::findOrFail($id);
        $client->approver_id = auth()->id();
        $client->save();
        $client->removeRole('pending-client');
        $client->assignRole('client');
        Notification::send($client, new ClientApprovedNotification($client));

        return response()->json(['message' => 'Client approved successfully', 'client' => $client]);
    }

    public function myApproved()
    {
        $clients = User::role('client')->where('approver_id', auth()->id())->get();
        return response()->json(['approved_clients' => $clients]);
    }

    public function clientsReservations()
    {
        $reservations = Auth::user()->hasRole("receptionist")
            ? Reservation::with('client')->whereIn('client_id', User::where('approver_id', auth()->id())->pluck('id'))->get()
            : Reservation::with('client')->get();

        return response()->json(['reservations' => $reservations]);
    }
}
