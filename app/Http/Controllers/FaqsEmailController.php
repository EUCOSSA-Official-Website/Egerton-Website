<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use App\Models\User;
use App\Notifications\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class FaqsEmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $validated["read_at"] = null;

       // Store the message in the database
       ContactForm::create($validated);

       // Send an email to the specified address
        Mail::raw("Name: {$validated['name']}\nEmail: {$validated['email']}\nMessage: {$validated['message']}", function ($message) {
           $message->to('eucossake@gmail.com')
                   ->subject('New Contact Form Submission');
       });

        return response()->json(['message' => 'Email sent successfully.']);
    }
}
