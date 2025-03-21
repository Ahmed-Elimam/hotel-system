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
        $countries = Country::all()->sortBy('name'); // Sort them alphabetically
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
            'country' => $country,
            'phone' => $phone,
            'gender'=> $gender,
        ]);
        $user->assignRole('pending-client');
        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
}
