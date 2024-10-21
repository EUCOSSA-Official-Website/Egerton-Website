<?php

use App\Mail\EventCreated;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->everyMinute();

Schedule::call(function () {
    // Get the events created during the week
    $events = Event::where('created_at', '>=', now()->startOfWeek())
                    ->where('created_at', '<=', now()->endOfWeek())
                    ->get();

    // Retrieve all users from the database
    $users = User::all();

    foreach ($events as $event) {
        foreach ($users as $user) {
            Mail::to($user->email)->send(new EventCreated($event));
        }
    }
})->weeklyOn(4, '18:00'); // Thursday at 6 PM
// })->everyMinute();
