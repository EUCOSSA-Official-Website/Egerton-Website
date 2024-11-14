<?php

namespace App\Http\Controllers\Payments\Mpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaidEventRegistration extends Controller
{

    public function initiateEventPayment()
    {
        // Manually instantiate MpesaController Class
        $mpesaController = new MpesaController();

        $phone = 254794559089;
        $amount = 1;
        $callbackroute = '/event/register';

        $response  = $mpesaController->stkPush($phone, $amount, $callbackroute);

        return $response;
    }

}
