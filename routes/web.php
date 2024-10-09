<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\ProfileController;
use App\Models\Event;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return redirect()->route('login');
});

// The Dashboard Route
Route::get('/dashboard', function () {

    // Fetch the 7 most recent events. 
    $events = Event::orderBy('created_at', 'desc')->limit(7)->get();
    
    return Inertia::render('Dashboard', ['events' => $events]);

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/payments', function(){
    return inertia('Payments');
})->middleware(['auth', 'verified'])->name('payments');


// Redirect to Google
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google.redirect');

// Handle callback from Google
Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Check if the user already exists in the database
    $user = User::where('email', $googleUser->email)->first();

    if ($user) {
        // If the user exists, log them in directly
        Auth::login($user);
        return redirect('/dashboard');
    }

    // If the user doesn't exist, redirect to the GET route for the mobile registration form with query parameters
    return redirect()->route('register.mobile', [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'google_id' => $googleUser->getId(),
        'google_avatar' => $googleUser->getAvatar(),
    ]);
})->name('auth.google.callback');

Route::get('/register/mobile', function (Request $request) {
    // Check if we have the name and email from Google
    $googleName = $request->query('name');
    $googleEmail = $request->query('email');
    $googleId = $request->query('google_id');
    $googleAvatar = $request->query('google_avatar');

    if (!$googleName || !$googleEmail) {
        return redirect('/'); // Redirect if data is missing
    }

    // Pass the data to the view (Vue component or Blade view)
    return inertia('RegisterMobile', [
        'googleName' => $googleName,
        'googleEmail' => $googleEmail,
        'googleId' => $googleId,
        'googleAvatar' => $googleAvatar
    ]);
})->name('register.mobile');

Route::post('/register/mobile/submit', function (Request $request) {
    // Validate the mobile number
    $request->validate([
        'mobile' => 'required|numeric',
    ]);

    // Get the Google name and email from the request
    $googleName = $request->input('name');
    $googleEmail = $request->input('email');
    $googleId = $request->input('google_id');
    $googleAvatar = $request->input('google_avatar');

    // Create a new user with the provided Google info and mobile number
    $user = User::create([
        'name' => $googleName,
        'email' => $googleEmail,
        'email_verified_at' => now(),
        'mobile' => $request->mobile,
        'password' => null, // No password needed for Google login
        'google_id' => $googleId,
        'google_avatar' => $googleAvatar,
    ]);

    // Log in the user
    Auth::login($user);
    

    // Redirect to the dashboard
    return redirect('/dashboard');
})->name('register.mobile.submit');

Route::get('/call-for-speakers', function(){
    return inertia('Speakers');
})->middleware(['auth', 'verified'])->name('call-for-speakers');


// The Events Controller
Route::resource('/events', EventsController::class);
