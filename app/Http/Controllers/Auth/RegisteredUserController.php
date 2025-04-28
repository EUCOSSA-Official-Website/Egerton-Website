<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\WelcomeToEucossa;
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
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^\d]*$/'],
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'mobile' => ['required', 'regex:/^(07|01)\d{8}$/'], // Ensures the number starts with '07' and has 10 digits
            'reg_number' => ['required', 'regex:/^[A-Za-z0-9]{1,5}\/\d{5}\/\d{2}$/'], // Matches the required format
        ], [
            'mobile.regex' => 'The mobile number must be exactly 10 digits and start with 07. or 01.',
            'reg_number.regex' => 'The registration number format should be like S13/11101/30.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'reg_number' => $request->reg_number,
        ]);

        event(new Registered($user));

        $user->notify(new WelcomeToEucossa()); // 🔔 Send notification here

        Auth::login($user);

        return redirect(route('home'))->with('success', 'You\'ve been Registered successfully');
    }
}
