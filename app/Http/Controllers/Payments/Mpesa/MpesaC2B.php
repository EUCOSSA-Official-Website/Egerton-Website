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

        // Same split as up_saas: Business Short Code for C2B register; till is STK PartyB only.
        // Production register is one-time — delete URLs in Daraja URL Management, then re-register from production.
        $body = [
            'ShortCode' => env('MPESA_SHORTCODE'),
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
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }

    public function confirmation(Request $request)
    {
        $payload = $request->all();

        Log::info('C2B confirmation request', ['payload' => $payload]);

        try {
            $transId = $payload['TransID'] ?? null;

            if (!$transId) {
                Log::warning('C2B confirmation missing TransID', ['payload' => $payload]);
            } else {
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
            }
        } catch (\Exception $e) {
            Log::error('C2B confirmation processing failed', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);
        }

        // Always ack like up_saas — never fail the HTTP response to Safaricom
        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }
}
