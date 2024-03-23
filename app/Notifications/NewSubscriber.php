<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSubscriber extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $subscription;
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
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
                    ->greeting(__('Hey :streamerName,', ['streamerName' => $notifiable->name]))
                    ->subject(__('New Paid Subscriber'))
                    ->line(__(
                        'Congratulations, @:username just subscribed to your tier :tierName for :tokens tokens',
                        [
                            'username' => $this->subscription->subscriber->username,
                            'tierName' => $this->subscription->tier->tier_name,
                            'tokens' => $this->subscription->subscription_tokens
                        ]
                    ))
                    ->action(__('My Subscribers'), route('mySubscribers'))
                    ->line(__('Best Regards'));
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
            'username' => $this->subscription->subscriber->username,
            'profilePicture' => $this->subscription->subscriber->profile_picture,
            'tierName' => $this->subscription->tier->tier_name,
            'tokens' => $this->subscription->subscription_tokens,
            'renewalDate' => $this->subscription->subscription_expires->format('Y-m-d'),
            'isStreamer' => $this->subscription->subscriber->is_streamer
        ];
    }
}
