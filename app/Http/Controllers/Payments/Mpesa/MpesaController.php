<?php

namespace App\Http\Controllers\Payments\Mpesa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{

    public function getAccessToken()
    {
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => env('MPESA_CONSUMER_KEY') . ':' . env('MPESA_CONSUMER_SECRET'),
                CURLOPT_SSL_VERIFYPEER => false, // Disables SSL certificate verification
                CURLOPT_SSL_VERIFYHOST => false, // Disables SSL host verification
            )
        );
        $response = curl_exec($curl);

        // Check for errors
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            dd("cURL Error #: " . curl_errno($curl) . " - " . $error_msg);
        }

        curl_close($curl);

        // Check if the response is empty
        if (empty($response)) {
            dd("Empty response received from the API.");
        }

        $responseData = json_decode($response, true); // Decode the JSON response into an array

        //return view('welcome', ['responseData' => $responseData]);
        // dd($responseData['access_token']);
        return $responseData['access_token'];
    }

    public function makeHttp($url, $body)
    {

        $accessToken = $this->getAccessToken(); // Get access token first

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $accessToken)); // Correct authorization header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, \json_encode($body));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $curl_response = curl_exec($curl);
        \curl_close($curl);

        return $curl_response;
    }

    /*
    *Register URL Already was done. 
    */
    

    // The STK Push Logic
    public function stkPush($phone, $amount)
    {
        $timestamp = date('YmdHis');
        $password = env('MPESA_SHORTCODE').env('MPESA_PASSKEY').$timestamp;

        

        $data = [
            "BusinessShortCode" => env('MPESA_SHORTCODE'),
            "Password" => base64_encode($password),
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerBuyGoodsOnline",
            "Amount" => $amount,
            "PartyA" => $phone,
            "PartyB" => env('MPESA_TILL'),
            "PhoneNumber" => $phone,
            "CallBackURL" => "https://a41b-2c0f-fe38-2016-21b0-10fc-17cd-88be-46db.ngrok-free.app/stkpush2",
            "AccountReference" => "EUCOSSA",
            "TransactionDesc" => "Registration"
        ];

        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $response = $this->makeHttp($url, $data);

        return $response;
    }

    // Registering For the Club
    public function register(Request $request)
    {

        $user = Auth::user();

        $registrationStatus = $user['registered'];

        if(!$registrationStatus){
            // Validating Input From Form
            $validatedData = $request->validate([
                "phone" => "required|numeric|digits_between:9,10",
                "amount" => "required|numeric|min:1",
            ]);

            //Restoring The Phone Number
            $validatedData["phone"] = "254{$validatedData["phone"]}";

            // Calling The STK Push Function
            $response = $this->stkPush($validatedData["phone"], $validatedData["amount"]);

            // Decode the JSON string to an associative array
            $response = json_decode($response, true); // 'true' for associative array

            $responseCode = $response["ResponseCode"];

            // Adding Checkout ID to Users Column for registering users. 
            if($responseCode === "0"){
                User::where('id', $user['id'])->update([
                    "mpesa_checkout_id" => $response["CheckoutRequestID"],
                ]);
            }
            
            // return "Processing has began! ";
        } else {
            $response = "You Are Already Registered!";
        }
    }
    

    // The MPESA CALLBACK Route For Registration Only. 
    public function stkpush2(Request $request)
    {
        // Decode the JSON body from Safaricom
        $callbackData = $request->json()->all();

        // The Mpesa Checkout ID
        $mpesaCheckoutID = $callbackData['Body']['stkCallback']['CheckoutRequestID'];

        // Check for a successful transaction
        if (isset($callbackData['Body']['stkCallback']['ResultCode']) 
            && $callbackData['Body']['stkCallback']['ResultCode'] == 0) {


            // Add the if statement here to check whether the payment of ksh 50 was successful. 
            User::where('mpesa_checkout_id', $mpesaCheckoutID)->update([
                'registered' => now(),
            ]);

        }

        return response()->json(['message' => 'Payment failed'], 400);
    }

}
