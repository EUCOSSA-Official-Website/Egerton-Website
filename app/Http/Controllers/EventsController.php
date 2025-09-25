<?php

namespace App\Http\Controllers;

use App\Mail\EventCreated;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        if ($limit) {
            $eventQuery = Event::with('eventReactions')->limit($limit);
        } else {
            $eventQuery = Event::with('eventReactions');
        }

        // Get all events and include reactions for the authenticated user
        $events = $eventQuery
            ->orderBy('event_day', 'desc')
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
                    'category' => $event->category,
                    'reminder' => $event->reminder,
                    'creator_id' => $event->creator_id,
                    'user_reaction' => $event->user_reaction,  // Either 'like' or 'dislike'
                    'likes' => $likes,
                    'dislikes' => $dislikes,
                ];
            });

        return $events;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:8192', // Enforce strict MIME type check            'event_day' => 'required|date|after_or_equal:today', // Ensure the event day is today or in the future
            'event_day' => 'required|date|after_or_equal:today', // Ensure the event day is today or in the future
            'start_time' => 'required',
            'end_time' => 'required',
            'speaker' => 'required|string|max:255',
            'event_charge' => 'nullable|numeric'
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
        $event = Event::create($validatedData);

        // The Email Sending Part. 
        // Retrieve all users from the database
        $users = User::all();

        // Send the email to each user
        // foreach ($users as $user) {
        //     Mail::to($user->email)->send(new EventCreated($event));
        // }
        foreach ($users as $user) {
            if($user->email == 'njaus602@gmail.com'){
                Mail::to($user->email)->send(new EventCreated($event));
            }
        }

        // Redirect back with a success message or redirect to the events list
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // Passing the Reactions of the currently Authenticated user. 
        $userId = Auth::id(); // Get the authenticated user's ID

        return inertia("Events/Show", [
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // Admin Authorization for this Route        
        Gate::allowIf(fn($user) => $user->role === 'admin');
        // Editing the Event
        return inertia("Events/Edit", [
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Admin Authorization for this Route        
        Gate::allowIf(fn($user) => $user->role === 'admin');

        $event->update(
            $request->validate([
                'category' => 'required|string',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|mimes:jpeg,png,jpg,gif|mimetypes:image/jpeg,image/png,image/jpg,image/gif|max:8192', // Enforce strict MIME type check            'event_day' => 'required|date|after_or_equal:today', // Ensure the event day is today or in the future
                'event_day' => 'required|date|after_or_equal:today', // Ensure the event day is today or in the future
                'start_time' => 'required',
                'end_time' => 'required',
                'speaker' => 'required|string|max:255',
                'event_charge' => 'nullable|numeric'
            ])
        );

        // Redirect back with a success message or redirect to the events list
        return redirect()->route('events.index')->with('success', 'Event Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Authorize using Gate
        Gate::allowIf(fn($user) => $user->role === 'admin');

        // Delete the image from storage if it exists
        if ($event->image) {
            // Parse the image path (if it's a URL, strip the domain part)
            $imagePath = str_replace(asset('storage') . '/', '', $event->image);

            // Check if the file exists in storage and delete it
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        // Delete the event record from the database
        $event->delete();

        // Redirect back to events index with a success message
        return redirect()->route('events.index')->with('success', 'Event and associated image deleted successfully!');
    }


}
