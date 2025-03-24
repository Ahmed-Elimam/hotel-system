<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientStoreRequest;
use App\Models\User;
use App\Models\Country;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        $countries = Country::orderBy('name')->get()->toArray(); // Sort them alphabetically
        return Inertia::render('auth/Register', ['countries' => $countries]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ClientStoreRequest $request): RedirectResponse
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
            'country_id' => $country_id,
            'phone' => $phone,
            'gender'=> $gender,
        ]);
        $user->assignRole('pending-client');

        event(new Registered($user));

        return to_route('home')->with('success', 
        "Thank you for registering! We’re excited to welcome you as a guest at our hotel. Your registration is under review, and we will notify you via email once it is approved.");
    }
}
