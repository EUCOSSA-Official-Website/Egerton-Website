<?php

namespace App\Http\Controllers\Payments\Mpesa;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Subscription;
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
            dump("cURL Error #: " . curl_errno($curl) . " - " . $error_msg);
        }

        curl_close($curl);

        // Check if the response is empty
        if (empty($response)) {
            dump("Empty response received from the API.");
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
    public function stkPush($phone, $amount, $callbackRoute)
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
            "CallBackURL" => env('APP_ENV') == 'local' ? env('MPESA_TEST_URL') . "/{$callbackRoute}" : env('MPESA_PRODUCTION_URL') . "/{$callbackRoute}",
            "AccountReference" => "EUCOSSA",
            "TransactionDesc" => "Registration"
        ];

        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $response = $this->makeHttp($url, $data);

        return $response;
    }

    // Registering For the Club (The function sending STK push to User)
    public function register(Request $request)
    {

        $user = Auth::user();

        $registrationStatus = $user['registered'];

        if(!$registrationStatus){
            // Validating Input From Form
            $validatedData = $request->validate([
                "phone" => "required|numeric|digits_between:9,10",
                "amount" => "required|numeric|min:" . (env('APP_ENV') == 'local' ? 1 : 50),
            ]);

            //Restoring The Phone Number
            $validatedData["phone"] = "254{$validatedData["phone"]}";

            // Calling The STK Push Function
            $response = $this->stkPush($validatedData["phone"], $validatedData["amount"], "register2");

            // Decode the JSON string to an associative array
            $response = json_decode($response, true); // 'true' for associative array

            $responseCode = $response["ResponseCode"];

            // Adding Checkout ID to Users Column for registering users. 
            if($responseCode === "0"){
                User::where('id', $user['id'])->update([
                    "mpesa_checkout_id" => $response["CheckoutRequestID"],
                ]);                
            }
            
            // THE RESPONSE FROM MPESA (SERVICE REQUEST IS PROCESSED SUCCESSFULLY)
            return redirect()->route('payments')->with('success', "{$response["CustomerMessage"]} - Enter Mpesa Pin To Pay Registration!");
        } else {
            $response = "FAILED!! You Are Already Registered!";

            return redirect()->route('payments')->with('success', $response);
        }
    }
    

    // The MPESA CALLBACK Route For Registration Only. (The function processing callback from Safaricom. )
    public function register2(Request $request)
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

            // Respond with a success acknowledgment for Safaricom
            return response()->json(['message' => 'Payment processed successfully'], 200);

        }

        return response()->json(['message' => 'Processing The Payment Failed'], 400);
    }




    // The function To send STK Push to Safaricom For subscription
    public function subscribe(Request $request)
    {

        $userId = Auth::id();

        // Validating the forms data. 
        $validatedData = $request->validate([
            "phone" => "required|numeric|digits_between:9,10",
            "amount" => "required|numeric|min:" . (env('APP_ENV') == 'local' ? 1 : 50),
        ]);


        // Restoring 254 Precursor to The Received Phone
        $validatedData['phone'] = "254{$validatedData['phone']}";

        // stkPush($phone, $amount, $callbackRoute)
        $response = $this->stkpush($validatedData['phone'], $validatedData['amount'], "/subscribe50");

        $response = json_decode($response, true);

        if($response["ResponseCode"] == 0){
            User::where('id', $userId)->update([
                "mpesa_checkout_id" => $response["CheckoutRequestID"],
            ]);

            // return $response["CustomerMessage"];
            return redirect()->route('payments')->with('success', $response["CustomerMessage"]);

        // return session()->flash('success', 'STK Push initiated successfully.');
        } else {
            return redirect()->route('payments')->with('success', $response["CustomerMessage"]);
        }
    }

    public function subscribe50(Request $request)
    {

        // The Response From MPESA
        $mpesaResponse = json_decode($request->getContent(), true);

        if($mpesaResponse["Body"]["stkCallback"]["ResultCode"] == 0){
            
            $checkoutId = $mpesaResponse["Body"]["stkCallback"]["CheckoutRequestID"];

            // Getting The ID of the User who Has Just Paid
            $userId = User::where("mpesa_checkout_id", $checkoutId)->first();

            // Getting The Amount
             // Extract amount from CallbackMetadata
            $amount = null;
            foreach ($mpesaResponse["Body"]["stkCallback"]["CallbackMetadata"]["Item"] as $item) {
                if ($item["Name"] === "Amount") {
                    $amount = $item["Value"];
                    break;
                }
            }

            // Check if amount was found
            if ($amount === null) {
                return response()->json(['message' => 'Amount not found in response.'], 400);
            }
            
            // Logic to Determine if A user has contributed in the Current Semester
            Subscription::create([
                'user_id' => $userId['id'],
                'year' => date('Y'), 
                'semester' => Subscription::getCurrentSemester()['semester'], 
                'amount' => $amount
            ]);

            return response()->json(['message' => $mpesaResponse["Body"]["stkCallback"]["ResultDesc"]], 200);
        } else {
            return response()->json(['message' => $mpesaResponse["Body"]["stkCallback"]["ResultDesc"]], 400);
        }
    }

    // Initializing an STK push for The Donations
    public function donate(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|numeric|digits_between:9,10',
            'amount' => 'required|numeric|min:1'
        ]);

        // Restoring 254 to the Phone
        $validatedData['phone'] = "254{$validatedData["phone"]}";

        // Sending The STK push to the Phone
        $response = $this->stkPush($validatedData['phone'], $validatedData['amount'], '/donate1');

        // Decoding The JSON response
        $response = json_decode($response, true);

        // Check if Donor is Authenticated
        $donor = Auth::user();

        if($response["ResponseCode"] == 0 && isset($donor)){
            User::where('id', $donor['id'])->update([
                'mpesa_checkout_id' => $response["CheckoutRequestID"],
            ]);
        }


        // return $response;

        return redirect()->route('payments')->with('success', $response["CustomerMessage"]);


    }

    public function donate1(Request $request)
    {
        $request = json_decode($request->getContent(), true);

        $checkoutId = $request["Body"]["stkCallback"]["CheckoutRequestID"];

        $userID = User::where("mpesa_checkout_id", $checkoutId)->pluck('id')->first() ?? null;
        $userName = User::where("mpesa_checkout_id", $checkoutId)->pluck('name')->first() ?? null;
        
        $items = $request["Body"]["stkCallback"]["CallbackMetadata"]["Item"];

        $amount = null;
        foreach($items as $item){            
            if($item["Name"] == "Amount"){
                $amount = $item["Value"];
                break;
            }
        }              

        if($userID){
            Donation::create([
                'system_id' => $userID,
                'donor' => 'member',
                'donor-name' => $userName,
                'amount' => $amount,
                'source' => "mpesa"
            ]);
        }
        return response()->json(['message' => "Route Hit Successfully"], 200);
    }    
}
