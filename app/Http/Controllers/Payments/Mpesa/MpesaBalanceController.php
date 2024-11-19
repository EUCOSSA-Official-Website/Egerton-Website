<?php

namespace App\Http\Controllers\Payments\Mpesa;

use App\Http\Controllers\Controller;
use App\Models\FinanceBalance;
use Illuminate\Http\Request;

// The Purpose of This Controller is To Check The Account Balance from MPESA
class MpesaBalanceController extends Controller
{
    public function checkMpesaBalance()
    {
        $mpesaController = new MpesaController();

        $url = 'https://api.safaricom.co.ke/mpesa/accountbalance/v1/query';

        // Set up the body for the API request
        $body = [
            "Initiator" => env('MPESA_BALANCE_API_USERNAME'),
            "SecurityCredential" => "MZi9cWjh77NUrXC9AL7qmFaNse4IUolTpmlxzcHjq50CV7OuBM97ZXVBrq9HT6QxzpRXv1eX3cGAzB4UBI0NysAKhsWbRfjC/GmHdZv3SqYkfRNxsza+d74wXr/GF/zeFiMs6qFqNt8n7nMFhtI8fLSbk8SLjoUJyV2RjYP8ie2gZ0LpdOBuLdEwDe30eGZbG0n9vauUGTN4SrPgmM3wsUexZ8Q3gknE9UVDjJ41GQgouUkUXAAlhFMQ3uT/DXVvhXWuOG0UIDS27diJNHosEI68ijmMASzqxnJJMLYyb4MjCuv/LJ7AmncynHmddTReiGS+ZH829+2ZBUasfG5gfQ==",
            "CommandID" => "AccountBalance",
            "PartyA" => env('MPESA_BALANCE_API_SHORTCODE'),
            "IdentifierType" => 4,
            "Remarks" => "Tests",
            "QueueTimeOutURL" => "https://b52f-154-159-237-172.ngrok-free.app/balance-result",
            "ResultURL" => "https://b52f-154-159-237-172.ngrok-free.app/balance-result"
        ];

        $response = $mpesaController->makeHttp($url, $body);

        return $response;
    }

    public function receiveMpesaBalance(Request $request)
    {
        // Decode the JSON from Safaricom
        $response = json_decode($request->getContent(), true);
        $result = $response['Result'] ?? null;

        // Validate the result
        if (!$result || $result['ResultType'] !== 0 || $result['ResultCode'] !== 0) {
            return response()->json([
                'message' => $result['ResultDesc'] ?? 'Unknown error occurred.',
            ], 400);
        }

        // Extract parameters
        $resultParameters = collect($result['ResultParameters']['ResultParameter'] ?? []);
        $accountBalanceRaw = $resultParameters->firstWhere('Key', 'AccountBalance')['Value'] ?? null;
        $completedTimeRaw = $resultParameters->firstWhere('Key', 'BOCompletedTime')['Value'] ?? null;

        if (!$accountBalanceRaw || !$completedTimeRaw) {
            return response()->json(['error' => 'Missing account balance or timestamp.'], 400);
        }

        // Parse AccountBalance for Merchant Account balance
        $merchantAccountDetails = collect(explode('&', $accountBalanceRaw))
            ->first(fn($balance) => str_contains($balance, 'Merchant Account'));

        if (!$merchantAccountDetails) {
            return response()->json(['error' => 'Merchant account balance not found.'], 400);
        }

        // Extract Merchant Account details
        $merchantDetails = explode('|', $merchantAccountDetails);
        $currency = $merchantDetails[1] ?? 'Unknown';
        $currentBalance = $merchantDetails[2] ?? '0.00';

        // Format BOCompletedTime to a proper timestamp
        $retrievedAt = \Carbon\Carbon::createFromFormat('YmdHis', $completedTimeRaw);

        // Save to Balance model
        $balance = new FinanceBalance();
        $balance->gatway = 'MPESA';
        $balance->balance = $currentBalance;
        $balance->retrieved_at = $retrievedAt;
        $balance->save();

        return response()->json([
            'message' => 'Balance saved successfully.',
            'data' => [
                'currency' => $currency,
                'balance' => $currentBalance,
                'retrieved_at' => $retrievedAt->toDateTimeString(),
            ],
        ], 200);
    }


}
