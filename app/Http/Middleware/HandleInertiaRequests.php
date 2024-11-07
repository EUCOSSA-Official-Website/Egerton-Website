<?php

namespace App\Http\Middleware;

use App\Models\ContactForm;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // return array_merge(parent::share($request), [
        //     'auth' => [
        //         'user' => $request->user(),
        //     ],
        //     'unreadMessages' => ContactForm::unreadNotifications()->get(),  // Fetch unread messages globally
        //     'randomNumber' => 9
        // ]);

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'messages' => [
                'unreadMessages' => ContactForm::unreadNotifications()->count(),
                'allMessages' => ContactForm::all()->count(),
                'number' => 9
            ]
        ]);

    }
}
