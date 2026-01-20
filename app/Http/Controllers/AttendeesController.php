<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Support\Facades\Gate;
use App\Exports\EventAttendeesExport;
use App\Models\Event;
use Maatwebsite\Excel\Facades\Excel;
class AttendeesController extends Controller
{
    public function index()
    {
        // Authorize using Gate
        Gate::allowIf(fn($user) => $user->role === 'admin');

        // Get attendees grouped by event_id and include event + user contact info
        $events = EventRegistration::where('amount_paid', '>', 0)
            ->with([
                'event:id,title',          // Load only 'id' and 'title' from Event
                'user:id,name,email,mobile', // Load minimal user fields needed for contact
            ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('event_id'); // Group results by event_id

        return inertia('Dashboard/EventAttendees', [
            'events' => $events,
        ]);
    }

    public function exportEventAttendees($eventId, $type)
    {
        // Authorization check
        Gate::allowIf(fn($user) => $user->role === 'admin');

        $eventName = Event::where('id', $eventId)->value('title');

        $fileName = time() ."_".$eventName. "_event_attendees.{$type}";

        try {
            return Excel::download(new EventAttendeesExport($eventId), $fileName);
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

}
