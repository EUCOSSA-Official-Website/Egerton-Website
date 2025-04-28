<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Artisan;

class UserRoleController extends Controller
{
    public function updateRole(Request $request, User $user)
    {
        // Authorize using Gate
        Gate::allowIf(fn($user) => $user->role === 'admin');

        $validated = $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', 'User role updated.');
    }

    public function updateSuperAdmin(Request $request, User $user)
    {

        // Authorize using Gate
        Gate::allowIf(fn($user) => $user->role === 'admin');

        $validated = $request->validate([
            'is_super_admin' => 'required|boolean',
        ]);

        $user->is_super_admin = $validated['is_super_admin'];
        $user->save();

        return back()->with('success', 'User super admin status updated.');
    }

    public function clearCache()
    {
        // Authorize using Gate
        Gate::allowIf(fn($user) => $user->role === 'admin');

        Artisan::call('optimize:clear');
        
        return back()->with('success', 'Application cache cleared successfully.');
    }


    // Storing the FAQ in DB
    public function storeFaq(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:Payment Issues,Registration,Club Constitution,Other',
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        Faq::create($validated);

        return redirect()->back()->with('success', 'FAQ added successfully.');
    }
}
