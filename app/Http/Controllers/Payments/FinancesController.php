<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\MpesaC2BTransaction;
use Illuminate\Support\Facades\Gate;

class FinancesController extends Controller
{
    // Displaying The dashboards Payments Index page.
    public function index()
    {
        Gate::allowIf(fn($user) => $user->role === 'admin');

        $transactions = MpesaC2BTransaction::latest('trans_time')->latest('id')->get();

        return Inertia('Dashboard/Finances', [
            'transactions' => $transactions,
        ]);
    }
}
