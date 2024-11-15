<?php

use App\Http\Controllers\AttendeesController;
use App\Http\Controllers\CallForSpeakersController;
use App\Http\Controllers\EventReactionController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FaqsEmailController;
use App\Http\Controllers\Payments\FinancesController;
use App\Http\Controllers\Payments\Mpesa\MpesaController;
use App\Http\Controllers\Payments\Mpesa\PaidEventRegistration;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpeakersController;
use App\Models\ContactForm;
use App\Models\Event;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Gate;

Route::get('/', function () {
    return redirect()->route('home');
});

// The Home Route
Route::get('/home', function (EventsController $eventsController) {

    // Fetch the 7 most recent events from the EventsController Class. 
    $events = $eventsController->index(7);

    return Inertia::render('Home', ['events' => $events]);

})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/payments', function () {
    return inertia('Payments');
})->name('payments');


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
        return redirect('/home');
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


    // Redirect to the The Home Page. 
    return redirect('/home');
})->name('register.mobile.submit');

// The Call For Speakers Form
Route::resource('/call-for-speakers', SpeakersController::class)
    ->middleware(['auth', 'verified'])->except(['edit', 'create']);

// Public Access to the 'create' Method
Route::get('/call-4-speakers/create', [SpeakersController::class, 'create'])
    ->name('call-for-speakers.create');


// The Events Controller
Route::resource('/events', EventsController::class)->except(['index', 'create']);

// The Events page
Route::get('/events', function (EventsController $eventsController) {
    $events = $eventsController->index();

    return inertia('Events/Index', ['events' => $events]);
})->name('events.index');

// Liking Events Routes
Route::post('/events/{eventId}/reactions', [EventReactionController::class, 'toggleReaction'])->middleware('auth');

// GROUPING THE DASHBOARD ROUTES TOGETHER
Route::prefix('dashboard')
    ->name('dashboard')
    ->middleware(['auth'])    
    ->group(function() {
        // The Dashboard Route
        Route::get('/', function () {

            Gate::allowIf(fn($user) => $user->role === 'admin');
            
            return inertia('Dashboard/Dashboard');
        })->middleware(['auth'])->name('');

        // The Finances Controller
        Route::get('/finances', [FinancesController::class, 'index'])->name('.finances');

        // The Event Attendees Controller
        Route::get('/attendees', [AttendeesController::class, 'index'])->name('.attendees');

        // The Speakers for dashboard
        Route::get('/speakers', function (SpeakersController $speakersController)
        {

            $speakers = $speakersController->index();
            
            return inertia('Dashboard/Speakers', ['speakers' => $speakers]);
        })->middleware(['auth'])->name('.speakers');

        // The Creating An Event Route
        Route::get('/event/create', function (){
            return inertia('Dashboard/EventCreation');
        })->name('.events.create');

        // Analytics Route
        Route::get('/analytics', function ()
        {
            $feedback = ContactForm::orderBy('created_at', 'desc')->get();

            return inertia('Dashboard/Analytics', [
                'feedback' => $feedback,
            ]);
        })->name('.analytics');

        // Marking the User Feedback As Read
        Route::put('/analytics/{id}', function($id)
        {
            ContactForm::where('id', $id)->update([
                'read_at' => now(),
            ]);
        })->name('.analytics.seen');
});

// The Callback from fake MPESA
Route::post('/api/confirmation', [MpesaController::class, 'handleLocalCallback']);

// The STK Push URL For Initiating Payment. 
Route::post('/stkpush', [MpesaController::class, 'stkPush'])
    ->name('stkpush');

// The STK Push URL For Logging The Response. 
Route::post('stkpush2', [MpesaController::class, 'stkpush2'])
    ->name('stkpush2');

// The FAQ's Page
Route::get('/faqs', function()
{
    return inertia('Faqs');
})->name('faqs');

// The Message from the FAQS page
Route::post('/faqs-send-email', [FaqsEmailController::class, 'sendEmail'])
    ->name('faqs-send-email');

// The About Page
Route::get('/about', function()
{
    return inertia('About');
})->name('about');

// The Terms and conditions
Route::get('/terms-and-conditions', function()
{
    return inertia('Terms');
})->name('terms-and-conditions');


// ALL MPESA EXTRA ROUTES
// Registering with 50sh
Route::post('register50', [MpesaController::class, 'register'])
    ->middleware(['auth'])->name('register50');

// The Semester Subscriptions Class For Initiating STK
Route::post('/subscribe', [MpesaController::class, 'subscribe'])
    ->middleware(['auth'])->name('subscribe');

// The Semester Registrations Callback Route For Notifications From Mpesa. 
Route::post('/subscribe50', [MpesaController::class, "subscribe50"])->name('subscribe50');

// The Donations Route
Route::post('/donate', [MpesaController::class, 'donate'])->name('donate');
Route::post('/donate1', [MpesaController::class, 'donate1'])->name('donate1');

// The Check Balance API
Route::post('/balance', [MpesaController::class, 'checkMpesaBalance'])->name('balance');
Route::post('/balance-result', [MpesaController::class, 'receiveMpesaBalance'])->name('balance-result');

// The Registering for Events Route
Route::post('/mpesa/events/register/{event}', [PaidEventRegistration::class, 'initiateEventPayment'])->name('event-payment')->middleware(['auth']);
Route::post('/mpesa/events/register', [PaidEventRegistration::class, 'processEventPayment'])->name('event-payment-process');
