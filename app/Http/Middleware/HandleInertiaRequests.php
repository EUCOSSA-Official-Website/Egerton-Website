<?php

namespace App\Http\Middleware;

use App\Models\ContactForm;
use App\Models\Speaker;
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

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'messages' => [
                'unreadMessages' => ContactForm::unreadNotifications()->count(),
                'allMessages' => ContactForm::all()->count(),
                'pendingSpeakerApproval' => Speaker::speakerApproval()->count(),
                'notificationCount' => $request->user()?->unreadNotifications()->count() ?? null,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'errors' => fn () => $request->session()->get('errors'),
            ],
        ]);

    }
}
