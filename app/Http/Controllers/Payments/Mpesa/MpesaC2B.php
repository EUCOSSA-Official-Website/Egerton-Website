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
    /**
     * C2B troubleshooting: check cPanel access logs for POST /payments/c2b/confirm;
     * c2b-callbacks.log only records warnings and errors.
     */
    public function registerUrls()
    {
        Gate::allowIf(fn($user) => $user->role === 'admin');

        $mpesaController = new MpesaController();
        $baseUrl = env('APP_ENV') == 'local'
            ? env('MPESA_TEST_URL')
            : env('MPESA_PRODUCTION_URL');

        // Child store shortcode (5124736), not HO — per Safaricom API Support.
        // Production register is one-time — delete URLs in Daraja URL Management, then re-register from production.
        $body = [
            'ShortCode' => env('MPESA_APP_STORE_CODE'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => $baseUrl . '/payments/c2b/confirm',
            'ValidationURL' => $baseUrl . '/payments/c2b/validate',
        ];

        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v2/registerurl';
        $response = $mpesaController->makeHttp($url, $body);

        return response()->json(json_decode($response, true) ?? ['raw' => $response]);
    }

    public function validation(Request $request)
    {
        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }

    public function confirmation(Request $request)
    {
        $payload = $request->all();

        try {
            $transId = $payload['TransID'] ?? null;

            if (!$transId) {
                Log::channel('c2b-callbacks')->warning('C2B confirmation missing TransID', [
                    'payload' => $payload,
                ]);
            } else {
                $transTime = null;
                if (!empty($payload['TransTime'])) {
                    try {
                        $transTime = Carbon::createFromFormat('YmdHis', $payload['TransTime']);
                    } catch (\Exception $e) {
                        Log::channel('c2b-callbacks')->warning('Unable to parse C2B TransTime', [
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
            Log::channel('c2b-callbacks')->error('C2B confirmation processing failed', [
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
