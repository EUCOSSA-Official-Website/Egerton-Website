<?php

namespace App\Http\Controllers\Payments\Mpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaController extends Controller
{
    public function handleLocalCallback(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Received forwarded callback: ', $request->all());

        // Extract data from the request
        $data = $request->all();

        // You can store this data in the database or process it as needed
        // Example of storing it in the database (assuming you have a table):
        // YourModel::create($data);

        // Return a response to acknowledge receipt
        return response()->json(['status' => 'success', 'message' => 'Data received'], 200);
    }
}
