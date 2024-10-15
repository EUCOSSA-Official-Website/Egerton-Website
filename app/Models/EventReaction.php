<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventReaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'event_id', 'reaction'];

    // Specify a custom table name
    protected $table = 'event_user_reactions';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
