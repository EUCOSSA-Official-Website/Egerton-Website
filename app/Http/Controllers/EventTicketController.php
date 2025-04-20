<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Auth;

class EventTicketController extends Controller
{
    public function download($receipt)
    {
        $registration = EventRegistration::where('receipt_number', $receipt)->where('user_id', Auth::id())->firstOrFail();

        $pdf = Pdf::loadView('pdf.ticket', [
            'user' => $registration->user,
            'registration' => $registration,
            'event' => $registration->event
        ]);

        return $pdf->download('event-ticket.pdf');
    }
}
