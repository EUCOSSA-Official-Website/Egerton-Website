<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeToEucossa extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to EUCOSSA!')
            ->greeting("Hi {$notifiable->name},")
            ->line('Welcome to EUCOSSA - Egerton University Computer Science Students Association!')
            ->line('To officially join the club, click the Join EUCOSSA button on the homepage for further instructions.')
            ->action('Join EUCOSSA', url('/'))
            ->line('Alternatively, go to [eucossa.com/payments](https://eucossa.com/payments) to pay your subscription.')
            ->line('For any other question, feel free to speak to the admins through the form on [eucossa.com/faqs](https://eucossa.com/faqs).')
            ->line('We’re excited to have you with us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Welcome to EUCOSSA!',
            'message' => 'Thanks for registering! To officially join, visit the homepage and click "Join EUCOSSA", or go to the payments page. For help, check the FAQs.',
            'action_url' => url('/'),
            'user_name' => $notifiable->name, // Add the user's name to the notification data
        ];
    }
}
