<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\FinanceBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FinancesController extends Controller
{
    // Displaying The dashboards Payments Index page. 
    public function index()
    {

        Gate::allowIf(fn($user) => $user->role === 'admin');

        $balances = FinanceBalance::latest()->get();

        return Inertia('Dashboard/Finances', [
            'balances' => $balances
        ]);
    }
}
