<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'description', 'image', 'start_time', 'end_time', 'event_day', 'speaker', 'reminder', 'creator_id', 'created_at', 'updated_at', 'event_charge', 'mpesa_callback', 'receipt_number', 'amount_paid', 'category'];


    // Define the relationship with User through the pivot table
    public function user()
    {
        return $this->belongsToMany(User::class, 'event_user_reactions')
            ->withPivot('reaction')
            ->withTimestamps();
    }

    // Helper methods for counting likes and dislikes
    public function likesCount()
    {
        return $this->users()->wherePivot('reaction', 'like')->count();
    }

    public function dislikesCount()
    {
        return $this->users()->wherePivot('reaction', 'dislike')->count();
    }

    public function attendees(): HasMany {
        return $this->hasMany(Attendee::class);
    }// Define the relationship with EventReaction
    public function eventReactions(): HasMany
    {
        return $this->hasMany(EventReaction::class);
    }


}
