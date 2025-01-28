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

        $request->validate([
            'phoneNumber' => 'required|numeric|digits_between:9,10',
            'preferedName' => 'required',
        ]);

        // Variables for the push
        $phone = "254".substr($request->phoneNumber, -9);
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

    public function processEventPayment(Request $request)
    {
        // Decode the JSON body from Safaricom
        $callbackData = $request->json()->all();

        // Extract CallbackMetadata Items
        $items = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'];

        $amount = null;
        $receiptNumber = null;

        // Loop through the items to find Amount and MpesaReceiptNumber
        foreach ($items as $item) {
            if ($item['Name'] === 'Amount') {
                $amount = $item['Value'];
            }
            if ($item['Name'] === 'MpesaReceiptNumber') {
                $receiptNumber = $item['Value'];
            }
        }

        // The Mpesa Checkout ID
        $mpesaCheckoutID = $callbackData['Body']['stkCallback']['CheckoutRequestID'];

        // Check for a successful transaction
        if (isset($callbackData['Body']['stkCallback']['ResultCode']) 
            && $callbackData['Body']['stkCallback']['ResultCode'] == 0) {

            //Registering The User
            EventRegistration::where('mpesa_callback', $mpesaCheckoutID)->update([
                'receipt_number' => $receiptNumber,
                'amount_paid' => $amount
            ]);

            return response()->json(['message' => 'Payment Processed'], 200);
        }

        return response()->json(['message' => 'Payment failed'], 400);
    }

}
