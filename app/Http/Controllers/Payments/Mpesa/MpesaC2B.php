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
     * Post-deploy C2B verification:
     * 1. Make one live till payment to child store 5124736.
     * 2. Check storage/logs/c2b-callbacks.log for "C2B confirmation endpoint hit".
     * 3. Check cPanel Apache access logs for POST /payments/c2b/confirm at payment time.
     *    - Access hit + log hit + no DB row → inspect exceptions in c2b-callbacks.log
     *    - Access hit + no log → request died before controller (middleware/PHP fatal)
     *    - No access hit → Safaricom never reached eucossa.com (Daraja shortcode/support)
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
        $this->logCallbackHit('C2B validation endpoint hit', $request);

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }

    public function confirmation(Request $request)
    {
        $this->logCallbackHit('C2B confirmation endpoint hit', $request);

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

                Log::channel('c2b-callbacks')->info('C2B confirmation saved', [
                    'trans_id' => $transId,
                ]);
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

    private function logCallbackHit(string $message, Request $request): void
    {
        Log::channel('c2b-callbacks')->info($message, [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'fullUrl' => $request->fullUrl(),
            'content_type' => $request->header('Content-Type'),
            'headers' => [
                'user-agent' => $request->header('User-Agent'),
                'content-type' => $request->header('Content-Type'),
                'content-length' => $request->header('Content-Length'),
            ],
            'raw' => $request->getContent(),
            'payload' => $request->all(),
        ]);
    }
}
