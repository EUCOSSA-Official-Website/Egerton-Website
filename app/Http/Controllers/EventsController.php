<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Assuming you want the reaction of the currently authenticated user
        $userId = Auth::id(); // Get the authenticated user's ID

        // Get all events and include reactions for the authenticated user
        $events = Event::with(['eventReactions' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
        ->latest()
        ->get()
        ->map(function ($event) use ($userId) {
            // Check if the user has reacted to this event
            $reaction = $event->eventReactions->first();
            // Add a custom attribute for reaction to the event
            $event->user_reaction = $reaction ? $reaction->reaction : null;
            // Return only necessary data
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'image' => $event->image,
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'event_day' => $event->event_day,
                'speaker' => $event->speaker,
                'reminder' => $event->reminder,
                'creator_id' => $event->creator_id,
                'user_reaction' => $event->user_reaction,  // Either 'like' or 'dislike'
            ];
        });
        
        return Inertia::render('Events/Index', ['events' => $events]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
