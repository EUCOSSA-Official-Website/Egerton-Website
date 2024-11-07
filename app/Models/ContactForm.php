<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'message', 'read_at'];

    // Scope for unread messages
    public function scopeUnreadNotifications($query)
    {
        return $query->whereNull('read_at');
    }
}
