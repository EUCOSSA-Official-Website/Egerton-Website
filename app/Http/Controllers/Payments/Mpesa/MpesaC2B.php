<?php

namespace App\Http\Controllers\Payments\Mpesa;

use App\Http\Controllers\Controller;
use App\Models\MpesaC2BTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class MpesaC2B extends Controller
{
    public function registerUrls()
    {
        Gate::allowIf(fn($user) => $user->role === 'admin');

        $mpesaController = new MpesaController();
        $baseUrl = env('APP_ENV') == 'local'
            ? env('MPESA_TEST_URL')
            : env('MPESA_PRODUCTION_URL');

        $body = [
            // c2b.md: ShortCode is the org paybill/till that receives payments
            'ShortCode' => env('MPESA_TILL'),
            'ResponseType' => 'Completed',
            // Match URLs already used in Daraja / live callbacks
            'ConfirmationURL' => $baseUrl . '/api/confirmation',
            'ValidationURL' => $baseUrl . '/api/validation',
        ];

        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v2/registerurl';
        $response = $mpesaController->makeHttp($url, $body);

        return response()->json(json_decode($response, true) ?? ['raw' => $response]);
    }

    public function validation(Request $request)
    {
        Log::info('C2B validation request', ['payload' => $request->all()]);

        return response()->json([
            'ResultCode' => '0',
            'ResultDesc' => 'Accepted',
        ]);
    }

    public function confirmation(Request $request)
    {
        $payload = $request->all();

        Log::info('C2B confirmation request', ['payload' => $payload]);

        $transId = $payload['TransID'] ?? null;

        if (!$transId) {
            return response()->json(['message' => 'Missing TransID'], 400);
        }

        $transTime = null;
        if (!empty($payload['TransTime'])) {
            try {
                $transTime = Carbon::createFromFormat('YmdHis', $payload['TransTime']);
            } catch (\Exception $e) {
                Log::warning('Unable to parse C2B TransTime', [
                    'TransTime' => $payload['TransTime'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        MpesaC2BTransaction::updateOrCreate(
            ['trans_id' => $transId],
            [
                'transaction_type' => $payload['TransactionType'] ?? null,
                'trans_time' => $transTime,
                'trans_amount' => $payload['TransAmount'] ?? 0,
                'business_short_code' => $payload['BusinessShortCode'] ?? null,
                'bill_ref_number' => $payload['BillRefNumber'] ?? null,
                'org_account_balance' => $payload['OrgAccountBalance'] !== '' && isset($payload['OrgAccountBalance'])
                    ? $payload['OrgAccountBalance']
                    : null,
                'msisdn' => $payload['MSISDN'] ?? null,
                'first_name' => $payload['FirstName'] ?? null,
                'middle_name' => $payload['MiddleName'] ?? null,
                'last_name' => $payload['LastName'] ?? null,
            ]
        );

        return response()->json([
            'ResultCode' => '0',
            'ResultDesc' => 'Success',
        ]);
    }
}
