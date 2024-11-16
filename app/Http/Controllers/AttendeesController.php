<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Support\Facades\Gate;

class AttendeesController extends Controller
{
    public function index()
    {
        // Authorize using Gate
        Gate::allowIf(fn($user) => $user->role === 'admin');

        $events = EventRegistration::where('amount_paid', '>', 0)->get();

        return inertia('Dashboard/EventAttendees', [
            'events' => $events,
        ]);
    }
}
