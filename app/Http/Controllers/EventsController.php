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
    public function index($limit = null)
    {
        // Passing the Reactions of the currently Authenticated user. 
        $userId = Auth::id(); // Get the authenticated user's ID
        

        // Conditionally fetching events if limit is specified. 
        if ($limit){
            $eventQuery = Event::with('eventReactions')->limit($limit);
        } else {
            $eventQuery = Event::with('eventReactions');
        }

        // Get all events and include reactions for the authenticated user
        $events = $eventQuery
        ->latest()
        ->get()
        ->map(function ($event) use ($userId) {
            // Check if the authenticated user has reacted to this event
            $userReaction = $event->eventReactions->where('user_id', $userId)->first();
            $event->user_reaction = $userReaction ? $userReaction->reaction : null;

            // The Events Like and dislike counts:
            $likes = $event->eventReactions->where('reaction', 'like')->count();
            $dislikes = $event->eventReactions->where('reaction', 'dislike')->count();

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
                'likes' => $likes,
                'dislikes' => $dislikes
            ];
        });
        
        return $events;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Events/Create');
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
