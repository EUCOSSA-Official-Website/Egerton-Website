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

        // Get attendees grouped by event_id and include event names
        $events = EventRegistration::where('amount_paid', '>', 0)
            ->with('event:id,title') // Load only 'id' and 'title' from Event
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('event_id'); // Group results by event_id

        return inertia('Dashboard/EventAttendees', [
            'events' => $events,
        ]);
    }

}
