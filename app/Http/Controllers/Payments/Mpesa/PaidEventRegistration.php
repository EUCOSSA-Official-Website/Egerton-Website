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
            'email' => 'required|string|lowercase|email'
        ]);

        // Variables for the push
        $phone = "254".substr($request->phoneNumber, -9);
        $amount = $event->event_charge;
        $callbackroute = 'mpesa/events/register';
        $user = Auth::user();

        $response  = $mpesaController->stkPush($phone, $amount, $callbackroute);

        // Decode the JSON string to an associative array
        $response = json_decode($response, true); // 'true' for associative array

        $responseCode = $response["ResponseCode"] ?? null;

        if (!isset($response["ResponseCode"])) {
            return back()->with('error', 'Invalid response from Mpesa. Please try again.');
        }

        // Adding Checkout ID to Users Column for registering users. 
        if($responseCode === "0"){
            EventRegistration::create([
                'user_id' => $user->id,
                'prefered_name' => $request->preferedName,
                'event_id' => $event->id,
                'mpesa_callback' => $response["CheckoutRequestID"],
                'email' => $request->email,
            ]);

            return back()->with('success', "{$response["CustomerMessage"]} - Enter Your Mpesa Pin To Receive Ticket");
        }

        // If ResponseCode is not "0", return error message
        return back()->with('error', $response["ResponseDescription"]);
    }

    public function processEventPayment(Request $request)
    {
        // Decode the JSON body from Safaricom
        $callbackData = $request->json()->all();

        // Extract necessary fields
        $stkCallback = $callbackData['Body']['stkCallback'];
        $resultCode = $stkCallback['ResultCode'];
        $resultDesc = $stkCallback['ResultDesc'];
        $mpesaCheckoutID = $stkCallback['CheckoutRequestID'];

        // Check if the transaction was successful
        if ($resultCode == 0) {
            // Extract CallbackMetadata Items
            $items = $stkCallback['CallbackMetadata']['Item'];
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

            // Update the registration record
            EventRegistration::where('mpesa_callback', $mpesaCheckoutID)->update([
                'receipt_number' => $receiptNumber,
                'amount_paid' => $amount
            ]);

            return response()->json(['message' => 'Payment Processed'], 200);
        }

        // Handle cases where payment failed or was canceled
        if ($resultCode == 1032) {
            // Payment was canceled by the user
            return response()->json([
                'message' => 'Payment canceled by the user',
                'description' => $resultDesc,
            ], 400);
        }

        return response()->json([
            'message' => 'Payment failed',
            'description' => $resultDesc,
        ], 400);
    }

}
