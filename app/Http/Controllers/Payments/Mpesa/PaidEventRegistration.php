<?php

namespace App\Http\Controllers\Payments\Mpesa;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaidEventRegistration extends Controller
{

    public function initiateEventPayment(Request $request, Event $event)
    {
        // Manually instantiate MpesaController Class
        $mpesaController = new MpesaController();

        // Variables for the push
        $phone = 254794559089;
        $amount = $event->event_charge;
        $callbackroute = 'mpesa/events/register';
        $user = Auth::user();

        $response  = $mpesaController->stkPush($phone, $amount, $callbackroute);

        // Decode the JSON string to an associative array
        $response = json_decode($response, true); // 'true' for associative array

        $responseCode = $response["ResponseCode"];

        // Adding Checkout ID to Users Column for registering users. 
        if($responseCode === "0"){
            EventRegistration::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'mpesa_callback' => $response["CheckoutRequestID"],
            ]);
        }

        return $response;
    }

    public function processEventPayment()
    {
        
    }

}
