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
        // Validate the incoming request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:8192', // Enforce strict MIME type check            'event_day' => 'required|date|after_or_equal:today', // Ensure the event day is today or in the future
            'event_day' => 'required|date|after_or_equal:today', // Ensure the event day is today or in the future
            'start_time' => 'required',
            'end_time' => 'required',
            'speaker' => 'required|string|max:255',
            'reminder' => 'boolean',
        ]);
    
        // Handle file upload
        if ($request->hasFile('image')) {
            // Store the image and get the file path
            $path = $request->file('image')->store('events', 'public'); // Store in storage/app/public/events
            
            // Generate the full public URL of the image
            $validatedData['image'] = asset('storage/' . $path);  // Use asset to generate the accessible URL
        }
    
        // Add creator_id to the validated data
        $validatedData['creator_id'] = Auth::id(); // Assuming the authenticated user is the creator
    
        // Save the event to the database using the entire validated data array
        Event::create($validatedData);
    
        // Redirect back with a success message or redirect to the events list
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
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
