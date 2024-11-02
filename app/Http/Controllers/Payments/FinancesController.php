<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FinancesController extends Controller
{
    // Displaying The dashboards Payments Index page. 
    public function index()
    {

        Gate::allowIf(fn($user) => $user->role === 'admin');

        return Inertia('Dashboard/Finances');
    }
}
