<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'name', 'year_of_study', 'other_year', 'topic', 'description', 'stack', 'skill', 'phone', 'creator_id'];

    // Its relationship with User Class
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
