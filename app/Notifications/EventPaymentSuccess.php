<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class EventPaymentSuccess extends Notification
{

    protected $amount;
    protected $receiptNumber;

    /**
     * Create a new notification instance.
     */
    public function __construct($amount, $receiptNumber)
    {
        $this->amount = $amount;
        $this->receiptNumber = $receiptNumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     // return (new MailMessage)
    //     //     ->subject('Payment Successful')
    //     //     ->line("Your payment of KSH {$this->amount} was successful.")
    //     //     ->line("Receipt Number: {$this->receiptNumber}")
    //     //     ->line('The Ticket is in your email.')
    //     //     ->action('View Ticket', url('/tickets'))
    //     //     ->line('Thank you for your payment!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'amount' => $this->amount,
            'receipt_number' => $this->receiptNumber,
        ];
    }

    

    // Broadcast in real-time
    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage($this->toArray($notifiable)))->onConnection('sync');
    }

}
