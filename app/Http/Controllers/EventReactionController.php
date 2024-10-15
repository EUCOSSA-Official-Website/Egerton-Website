<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventReactionController extends Controller
{
    public function toggleReaction(Request $request, $eventId)
    {
        $request->validate([
            'reaction' => 'nullable|in:like,dislike',
        ]);

        $userId = Auth::id();

        // Find the event
        $event = Event::findOrFail($eventId);

        // Check if the user has already reacted to this event
        $reaction = EventReaction::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->first();

        if ($reaction) {
            // If the user has reacted, update the reaction
            if ($reaction->reaction === $request->reaction) {
                // If the same reaction is submitted, remove it
                $reaction->delete();
            } else {
                // Update to the new reaction
                $reaction->reaction = $request->reaction;
                $reaction->save();
            }
        } else {
            // Create a new reaction
            EventReaction::create([
                'user_id' => $userId,
                'event_id' => $eventId,
                'reaction' => $request->reaction,
            ]);
        }

    }
}
