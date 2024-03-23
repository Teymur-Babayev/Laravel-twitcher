<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ThanksNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $subscription;
    public $thanks_message;

    public function __construct(Subscription $subscription, $thanks_message)
    {
        $this->subscription = $subscription;
        $this->thanks_message = $thanks_message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'username' => $this->subscription->streamer->username,
            'profile_picture' => $this->subscription->streamer->profile_picture,
            'thanks_message' => $this->thanks_message
        ];
    }
}
