<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRequestProcessed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Withdrawal $withdrawal)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
                    ->subject(__("Payout Request Processed"))
                    ->greeting(__("Hey :name", ['name' => $notifiable->name]))
                    ->line(__('Your payout request of :moneyAmount made on :date was processed!', [
                        'moneyAmount' => opt('payment-settings.currency_symbol') . $this->withdrawal->amount,
                        'date' => $this->withdrawal->created_at->format('jS F Y')
                    ]))
                    ->action(__("Payout History"), route('payout.withdraw'))
                    ->line(__("Happy Spending!"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'amount' => $this->withdrawal->amount,
            'date' => $this->withdrawal->created_at->format('jS F Y'),
            'tokens' => $this->withdrawal->tokens
        ];
    }
}
